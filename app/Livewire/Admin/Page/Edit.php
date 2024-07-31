<?php

namespace App\Livewire\Admin\Page;

use Livewire\Component;
use App\Models\Core\Page;
use App\Models\Utility\Tag;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\LogActivity\LogUser;
use App\Models\Utility\IdentityWeb;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use WithFileUploads, LivewireAlert;

    public $thumbnail;
    public $title;
    public $content;
    public $created_at;
    public $meta_title;
    public $url;
    public $isPublished = false;
    public $status = 'Draft';
    public $pageId, $slug;
    public $prevThumbnail;
    public $tags = [];

    public function mount($id)
    {
        $data = Page::find($id);
        if ($data) {
            $this->pageId = $data->id;
            $this->title = $data->title;
            $this->slug = $data->slug;
            $this->meta_title = $data->meta_title;
            $this->content = $data->content;
            $this->created_at = $data->created_at->format('Y-m-d');
            $this->url = $data->slug;
            $this->status = $data->status;
            $this->prevThumbnail = $data->thumbnail;
            $this->isPublished = $data->status === 'Publish';

            $this->tags = $data->tags()->pluck('name')->toArray();
        }
    }

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
        return view('livewire.admin.page.edit', [
            'identitas' => $identitas,
            'existingTags' => $existingTags
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Edit Page']);
    }

    public function update()
    {
        try {
            $validateRules = [
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'title' => 'required',
                'created_at' => 'required|date',
                'content' => 'required',
            ];

            $validateMessages = [
                'title.required' => 'Judul tidak boleh kosong',
                'created_at.required' => 'Tanggal tidak boleh kosong',
                'created_at.date' => 'Format tanggal tidak valid',
                'content.required' => 'Konten tidak boleh kosong',
            ];

            $this->validate($validateRules, $validateMessages);

            $data = Page::find($this->pageId);
            $data->title = $this->title;
            $data->slug = Str::slug($this->title);
            $data->meta_title = Str::limit($this->title, 60);
            $data->status = $this->isPublished ? 'Publish' : 'Draft';

            if ($this->thumbnail) {
                if ($this->prevThumbnail && file_exists(public_path('storage/page/' . $this->prevThumbnail))) {
                    unlink(public_path('storage/page/' . $this->prevThumbnail));
                }

                $thumbnailName = Str::slug($this->title) . '.webp';
                $image = Image::make($this->thumbnail->getRealPath())->encode('webp', 80);
                $destinationPath = public_path('storage/page');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $image->save($destinationPath . '/' . $thumbnailName);
                $data->thumbnail = $thumbnailName;
            }

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
                    $filepath = "storage/page/{$filename}.{$mimetype}";
                    $image = Image::make($dataImg)->encode($mimetype, 75);
                    $image->save(public_path($filepath));
                    $img->removeAttribute('src');
                    $img->setAttribute('src', asset($filepath));
                    $existingImages[] = asset($filepath);
                } else {
                    $existingImages[] = $dataImg;
                }
            }

            $oldContentDom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $oldContentDom->loadHTML($data->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();

            $oldImages = $oldContentDom->getElementsByTagName('img');
            foreach ($oldImages as $oldImg) {
                $oldSrc = $oldImg->getAttribute('src');
                if (!in_array($oldSrc, $existingImages) && file_exists(public_path(parse_url($oldSrc, PHP_URL_PATH)))) {
                    unlink(public_path(parse_url($oldSrc, PHP_URL_PATH)));
                }
            }

            $data->content = $dom->saveHTML();
            $data->created_at = $this->created_at;
            $data->user_id = auth()->user()->id;

            $newTags = array_map('trim', $this->tags);
            $existingTags = Tag::whereIn('name', $newTags)->pluck('id', 'name')->toArray();

            $data->tags()->sync([]);

            foreach ($newTags as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );

                $data->tags()->attach($tag->id);
            }

            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Update',
                'description' => 'Mengubah halaman ' . $this->title
            ]);

            $data->save();

            $this->flash('success', 'Data berhasil diperbarui', [], route('admin.pages'));
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
