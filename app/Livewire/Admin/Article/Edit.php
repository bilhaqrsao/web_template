<?php

namespace App\Livewire\Admin\Article;

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

class Edit extends Component
{
    use WithFileUploads, LivewireAlert;

    public $thumbnail, $title, $content, $created_at, $meta_title, $url, $isPublished = false, $tags = [], $meta_description, $description, $prevThumbnail, $id;

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
        return view('livewire.admin.article.edit',[
            'identitas' => $identitas,
            'existingTags' => $existingTags,
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Article']);
    }

    public function updateDescription($value)
    {
        $this->meta_description = Str::limit($value, 160);
    }

    public function mount($id)
    {
        $article = Article::find($id);
        $this->prevThumbnail = $article->thumbnail;
        $this->title = $article->title;
        $this->url = $article->slug;
        $this->content = $article->content;
        $this->created_at = $article->created_at->format('Y-m-d');
        $this->meta_title = $article->meta_title;
        $this->url = $article->url;
        $this->isPublished = $article->status === 'Publish' ? 'Draft' : 'Publish';
        $this->meta_description = $article->meta_description;
        $this->description = $article->description;

        $tags = json_decode($article->tags_id);
        $this->tags = $tags ? Tag::whereIn('id', $tags)->pluck('name')->toArray() : [];

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($this->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, 'http') !== 0) {
                $img->setAttribute('src', asset('storage/article/' . $src));
            }
        }
        $this->content = $dom->saveHTML();
    }

    public function update()
    {
        $this->validate([
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'title' => 'required',
            'description' => 'required',
            'created_at' => 'required|date',
            'content' => 'required',
        ], [
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
            $article = Article::find($this->id);
            $article->title = $this->title;
            $article->slug = Str::slug($this->title);
            $article->meta_title = Str::limit($this->title, 60);
            $article->description = $this->description;
            $article->meta_description = Str::limit($this->description, 160);

            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml($this->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();

            $images = $dom->getElementsByTagName('img');
            $existingImages = [];

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
                    $existingImages[] = asset($filepath);
                } else {
                    $existingImages[] = $dataImg;
                }
            }

            // Find and delete unused images
            $oldContentDom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $oldContentDom->loadHTML($article->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();

            $oldImages = $oldContentDom->getElementsByTagName('img');
            foreach ($oldImages as $oldImg) {
                $oldSrc = $oldImg->getAttribute('src');
                if (!in_array($oldSrc, $existingImages) && file_exists(public_path(parse_url($oldSrc, PHP_URL_PATH)))) {
                    unlink(public_path(parse_url($oldSrc, PHP_URL_PATH)));
                }
            }

            $article->content = $dom->saveHTML();
            $article->status = $this->isPublished === 'Publish' ? 'Publish' : 'Draft';
            $article->user_id = auth()->user()->id;
            $article->tags_id = Tag::whereIn('name', $this->tags)->pluck('id')->toJson();
            if ($this->thumbnail) {
                if ($this->prevThumbnail && file_exists(public_path('storage/article/' . $this->prevThumbnail))) {
                    unlink(public_path('storage/article/' . $this->prevThumbnail));
                }
                $thumbnailName = Str::slug($this->title) . '.webp';
                $image = Image::make($this->thumbnail->getRealPath())->encode('webp', 80);
                $destinationPath = config('app.thumbnail_path', 'storage/article');
                if (!file_exists(public_path($destinationPath))) {
                    mkdir(public_path($destinationPath), 0755, true);
                }
                $image->save(public_path("{$destinationPath}/{$thumbnailName}"));
                $article->thumbnail = $thumbnailName;
            }

            $article->save();
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Update',
                'description' => "Memperbarui artikel dengan judul: {$this->title}",
            ]);
            $this->flash('success', 'Data berhasil diperbarui', [], route('admin.articles'));
        } catch (\Exception $e) {
            $this->alert('error', 'Failed to update article');
            Log::error("Failed to update article: {$e->getMessage()}");
        }
    }
}
