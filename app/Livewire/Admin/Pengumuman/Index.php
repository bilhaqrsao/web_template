<?php

namespace App\Livewire\Admin\Pengumuman;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Core\Pengumuman;
use App\Models\LogActivity\LogUser;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert;
    public $search, $data, $status;
    public $limit = 10;

    public function getListeners()
    {
        return [
            'deleteConfirmed' => 'deleteConfirmed',
            'changeStatus' => 'changeStatus',
        ];
    }

    public function render()
    {
        $datas = Pengumuman::orderBy('created_at','DESC')->when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->paginate($this->limit);
        return view('livewire.admin.pengumuman.index',[
            'datas' => $datas,
        ])->layout('components.admin_layouts.app')->layoutData([
            'title' => 'Pengumuman',
        ]);
    }

    public function delete($id)
    {
        $this->confirm('Apakah anda yakin ingin menghapus data ini?', [
            'onConfirmed' => 'deleteConfirmed',
            'onCancelled' => 'cancelled',
        ]);

        $this->data = Pengumuman::findOrfail($id);
    }

    public function deleteConfirmed()
    {
        if ($this->data->thumbnail) {
            $thumbnailPath = public_path('storage/pengumuman/' . $this->data->thumbnail);
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
            'detail' => 'Menghapus data pengumuman ' . $this->data->title,
        ]);
        $this->data->delete();
        $this->alert('success', 'Data Berhasil Dihapus');
    }

    public function ubahStatus($id)
    {
        $this->confirm('Apakah anda yakin ingin mengubah status data ini?', [
            'onConfirmed' => 'changeStatus',
            'onCancelled' => 'cancelled',
        ]);

        $this->data = Pengumuman::findOrfail($id);
    }

    public function changeStatus()
    {
        if($this->data->status == 'Draft'){
            $this->data->status = 'Publish';
        }else{
            $this->data->status = 'Draft';
        }
        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Update',
            'detail' => 'Mengubah status data pengumuman ' . $this->data->title,
        ]);
        $this->data->save();
        $this->alert('success', 'Status Berhasil Diubah');
    }
}
