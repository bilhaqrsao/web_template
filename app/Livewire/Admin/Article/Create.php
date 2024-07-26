<?php

namespace App\Livewire\Admin\Article;

use Exception;
use Livewire\Component;
use App\Models\Utility\Tag;
use Illuminate\Support\Str;
use App\Models\Core\Article;
use App\Models\LogActivity\LogUser;
use Livewire\WithFileUploads;
use App\Models\Utility\IdentityWeb;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

    public $thumbnail, $title, $content, $created_at, $meta_title, $url, $isPublished = false, $tags = [], $meta_description, $description;

    public function updatedTitle($value)
    {
        $this->url = Str::slug($value);
        $this->meta_title = Str::limit($value, 60);
        Log::info("Title updated: URL = {$this->url}, Meta Title = {$this->meta_title}");
    }

    public function render()
    {
        $identitas = IdentityWeb::first();
        $existingTags = Tag::get();
        return view('livewire.admin.article.create', [
            'identitas' => $identitas,
            'existingTags' => $existingTags,
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Article']);
    }

    public function updateDescription($value)
    {
        $this->meta_description = Str::limit($value, 160);
    }

    public function store()
    {
        $this->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'title' => 'required',
            'description' => 'required',
            'created_at' => 'required|date',
            'content' => 'required',
        ], [
            'thumbnail.required' => 'Thumbnail tidak boleh kosong',
            'thumbnail.image' => 'File yang diupload harus berupa gambar',
            'thumbnail.mimes' => 'Format gambar yang diperbolehkan adalah jpeg, png, jpg, gif, svg',
            'thumbnail.max' => 'Ukuran gambar maksimal 5MB',
            'title.required' => 'Judul tidak boleh kosong',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'created_at.required' => 'Tanggal tidak boleh kosong',
            'created_at.date' => 'Tanggal harus berupa tanggal',
            'content.required' => 'Konten tidak boleh kosong',
        ]);

        try {
            $data = new Article();
            $data->title = $this->title;
            $data->slug = Str::slug($this->title);
            $data->meta_title = Str::limit($this->title, 60);
            $data->description = $this->description;
            $data->meta_description = Str::limit($this->description, 160);

            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml($this->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();

            $images = $dom->getElementsByTagName('img');
            foreach ($images as $img) {
                $dataImg = $img->getAttribute('src');
                if (preg_match('/data:image/', $dataImg)) {
                    preg_match('/data:image\/(?<mime>.*?)\;/', $dataImg, $groups);
                    $mimetype = $groups['mime'];
                    $filename = uniqid();
                    $filepath = "storage/article/{$filename}.{$mimetype}";
                    $image = Image::make($dataImg)->encode($mimetype, 75);
                    $image->save(public_path($filepath));
                    $img->removeAttribute('src');
                    $img->setAttribute('src', asset($filepath));
                }
            }

            $data->content = $dom->saveHTML();

            if ($this->thumbnail) {
                $thumbnailName = Str::slug($this->title) . '.webp';
                $image = Image::make($this->thumbnail->getRealPath())->encode('webp', 80);
                $destinationPath = config('app.thumbnail_path', 'storage/article');
                if (!file_exists(public_path($destinationPath))) {
                    mkdir(public_path($destinationPath), 0755, true);
                }
                $image->save(public_path("{$destinationPath}/{$thumbnailName}"));
                $data->thumbnail = $thumbnailName;
            }

            $data->user_id = auth()->user()->id;
            $data->created_at = $this->created_at;
            $data->status = $this->isPublished ? 'Publish' : 'Draft';

            if ($this->tags) {
                $tagIds = [];
                foreach ($this->tags as $tag) {
                    $tagModel = Tag::firstOrCreate(['name' => $tag], ['slug' => Str::slug($tag)]);
                    $tagIds[] = (string) $tagModel->id;
                }
                $data->tags_id = json_encode(array_map('strval', $tagIds), JSON_UNESCAPED_SLASHES);
            } else {
                $data->tags_id = json_encode([]);
            }

            $data->save();

            // create log
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Create',
                'description' => "Menambahkan artikel dengan judul: {$this->title}",
            ]);
            $this->flash('success', 'Data berhasil disimpan', [], route('admin.articles'));
        } catch (Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
