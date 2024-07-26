<?php

namespace App\Livewire\Admin\Article;

use Livewire\Component;
use App\Models\Core\Article;
use App\Models\LogActivity\LogUser;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination,LivewireAlert;
    public $limit = 10;
    public $search, $data;

    public function getListeners()
    {
        return [
            'changeStatusData' => 'changeStatusData',
            'deleteData' => 'deleteData',
        ];
    }

    public function render()
    {
        $datas = Article::orderBy('created_at')->when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->paginate($this->limit);
        return view('livewire.admin.article.index',[
            'datas' => $datas
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Article']);
    }

    public function showMore()
    {
        $this->limit += 10;
    }

    public function delete($id)
    {
        $this->confirm('Apakah anda yakin ingin menghapus data ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'deleteData',
        ]);

        $this->data = Article::findOrFail($id);
    }

    public function deleteData()
    {
        if ($this->data->thumbnail) {
            $thumbnailPath = public_path('storage/article/' . $this->data->thumbnail);
            Log::info("Thumbnail path: {$thumbnailPath}");
            if (file_exists($thumbnailPath)) {
                if (unlink($thumbnailPath)) {
                    Log::info("Thumbnail deleted successfully: {$thumbnailPath}");
                } else {
                    Log::error("Failed to delete thumbnail: {$thumbnailPath}");
                }
            } else {
                Log::warning("Thumbnail file not found: {$thumbnailPath}");
            }
        }

        // delete images from content
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $content = mb_convert_encoding($this->data->content, 'HTML-ENTITIES', 'UTF-8');

        try {
            $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        } catch (\Exception $e) {
            Log::error("Failed to load HTML: " . $e->getMessage());
        }

        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // Log the original src
            Log::info("Original image src: {$src}");

            // Assume that $src is relative to the public folder, if it's not an absolute URL
            if (strpos($src, 'http://') === false && strpos($src, 'https://') === false) {
                $imagePath = public_path($src);
            } else {
                // If it's an absolute URL, extract the path part
                $imagePath = public_path(parse_url($src, PHP_URL_PATH));
            }

            Log::info("Computed image path: {$imagePath}");

            if (file_exists($imagePath)) {
                if (unlink($imagePath)) {
                    Log::info("Image deleted successfully: {$imagePath}");
                } else {
                    Log::error("Failed to delete image: {$imagePath}");
                }
            } else {
                Log::warning("Image file not found: {$imagePath}");
            }
        }

        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Delete',
            'description' => "Menghapus artikel dengan judul: {$this->data->title}",
        ]);

        $this->data->delete();
        $this->alert('success', 'Data Berhasil Dihapus');
    }


    public function changeStatus($id)
    {
        $this->confirm('Apakah anda yakin ingin mengubah status data ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'changeStatusData',
        ]);

        $this->data = Article::findOrfail($id);
    }

    public function changeStatusData()
    {
        if ($this->data->status == 'Draft') {
            $this->data->status = 'Publish';
        } else {
            $this->data->status = 'Draft';
        }
        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Update',
            'description' => "Mengubah status artikel dengan judul: {$this->data->title} menjadi {$this->data->status}",
        ]);
        $this->data->save();
        $this->alert('success', 'Status berhasil diubah');
    }
}
