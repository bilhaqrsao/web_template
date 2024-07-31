<?php

namespace App\Livewire\Admin\Page;

use Livewire\Component;
use App\Models\Core\Page;
use App\Models\Utility\Tag;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Utility\PivotTags;
use App\Models\LogActivity\LogUser;
use App\Models\Utility\IdentityWeb;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

    public $thumbnail;
    public $title;
    public $content;
    public $created_at;
    public $meta_title;
    public $url;
    public $isPublished = false;
    public $tags = []; // Properti untuk tag yang dikirimkan dari frontend

    public function updatedTitle($value)
    {
        $slug = Str::slug($value);
        $this->url = $slug;
        $this->meta_title = Str::limit($value, 60);
    }

    public function render()
    {
        $identitas = IdentityWeb::first();
        $existingTags = Tag::get();
        return view('livewire.admin.page.create')
            ->with([
                'identitas' => $identitas,
                'existingTags' => $existingTags,
            ])
            ->layout('components.admin_layouts.app')
            ->layoutData(['title' => 'Buat Pages']);
    }

    public function store()
    {
        try {
            $this->validate([
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title' => 'required',
                'created_at' => 'required|date',
                'content' => 'required',
            ], [
                'thumbnail.required' => 'Gambar thumbnail tidak boleh kosong',
                'thumbnail.image' => 'File yang diupload harus berupa gambar',
                'thumbnail.mimes' => 'Format gambar yang diperbolehkan adalah jpeg, png, jpg, gif, svg',
                'thumbnail.max' => 'Ukuran gambar maksimal 2MB',
                'title.required' => 'Judul tidak boleh kosong',
                'title.min' => 'Judul minimal 10 karakter',
                'created_at.required' => 'Tanggal tidak boleh kosong',
                'created_at.date' => 'Format tanggal tidak valid',
                'content.required' => 'Konten tidak boleh kosong',
                'content.min' => 'Konten minimal 100 karakter',
            ]);

            $data = new Page();
            $data->title = $this->title;
            $data->slug = Str::slug($this->title);
            $data->meta_title = Str::limit($this->title, 60);
            $data->status = $this->isPublished ? 'Publish' : 'Draft';

            if ($this->thumbnail) {
                $thumbnailName = Str::slug($this->title) . '.webp';
                $image = Image::make($this->thumbnail->getRealPath())->encode('webp', 80);
                $destinationPath = config('app.thumbnail_path', 'storage/page');
                if (!file_exists(public_path($destinationPath))) {
                    mkdir(public_path($destinationPath), 0755, true);
                }
                $image->save(public_path("{$destinationPath}/{$thumbnailName}"));
                $data->thumbnail = $thumbnailName;
            }

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
                    $filepath = "storage/page/{$filename}.{$mimetype}";
                    $image = Image::make($dataImg)->encode($mimetype, 75);
                    $image->save(public_path($filepath));
                    $img->removeAttribute('src');
                    $img->setAttribute('src', asset($filepath));
                }
            }

            $data->content = $dom->saveHTML();
            $data->created_at = $this->created_at;
            $data->user_id = auth()->user()->id;

            $data->save(); // Save the page first to get the id

            // Handle tags
            foreach ($this->tags as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );

                // Create pivot entry
                PivotTags::updateOrCreate(
                    [
                        'taggable_type' => 'page',
                        'taggable_id' => $data->id,
                        'tag_id' => $tag->id,
                    ],
                    [
                        'taggable_type' => 'page',
                        'taggable_id' => $data->id,
                        'tag_id' => $tag->id,
                    ]
                );
            }
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Create',
                'description' => 'Menambahkan halaman ' . $this->title
            ]);

            $this->flash('success', 'Data berhasil disimpan', [], route('admin.pages'));
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
