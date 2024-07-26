<?php

namespace App\Livewire\Admin\Pengumuman;

use Livewire\Component;
use App\Models\Utility\Tag;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Core\Pengumuman;
use App\Models\LogActivity\LogUser;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use WithFileUploads,LivewireAlert;
    public $title, $content, $prevImage, $image, $dataId, $status, $tags, $created_at;

    public function render()
    {
        $existingTags = Tag::get();
        return view('livewire.admin.pengumuman.edit',[
            'existingTags' => $existingTags,
        ])->layout('components.admin_layouts.app')->layoutData([
            'title' => 'Edit Pengumuman',
        ]);
    }

    public function mount($id)
    {
        $data = Pengumuman::findOrfail($id);
        $this->dataId = $id;
        $this->title = $data->title;
        $this->content = $data->content;
        $this->prevImage = $data->image;
        $this->created_at = $data->created_at->format('Y-m-d');
        $tags = json_decode($data->tags_id);
        $this->tags = $tags ? Tag::whereIn('id', $tags)->pluck('name')->toArray() : [];

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($this->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, 'http') !== 0) {
                $img->setAttribute('src', asset('storage/page/' . $src));
            }
        }
        $this->content = $dom->saveHTML();
    }

    public function update()
    {
        $validate = $this->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ],[
            'title.required' => 'Judul tidak boleh kosong',
            'content.required' => 'Konten tidak boleh kosong',
            'image.image' => 'File harus berupa gambar',
        ]);

        if($validate){
            $data = Pengumuman::findOrfail($this->dataId);
            $data->title = $this->title;
            $data->slug = Str::slug($this->title);
            $data->created_at = $this->created_at;
            $data->user_id = auth()->user()->id;
            if($this->image){
               if ($this->prevImage && file_exists(public_path('storage/pengumuman/' . $this->prevImage))) {
                    unlink(public_path('storage/pengumuman/' . $this->prevImage));
                }
                $imgName = Str::slug($this->title) . '.webp';
                $img = imagecreatefromstring(file_get_contents($this->image->getRealPath()));
                $destinationPath = public_path('storage/pengumuman');
                if(!file_exists($destinationPath)){
                    mkdir($destinationPath, 0755, true);
                }
                imagewebp($img, $destinationPath . '/' . $imgName, 80);
                $data->image = $imgName;
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
                    $filepath = "storage/pengumuman/{$filename}.{$mimetype}";
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
            if ($this->tags) {
                $tagIds = [];
                foreach ($this->tags as $tag) {
                    // Tambahkan tag baru jika belum ada, atau ambil ID jika sudah ada
                    $tagModel = Tag::firstOrCreate(['name' => $tag], ['slug' => Str::slug($tag)]);
                    $tagIds[] = (string) $tagModel->id; // Konversi ID ke string
                }
                $data->tags_id = json_encode(array_map('strval', $tagIds), JSON_UNESCAPED_SLASHES); // Simpan ID sebagai JSON dalam bentuk string
            } else {
                $data->tags_id = json_encode([]); // Simpan array kosong jika tidak ada tag
            }
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Update',
                'description' => 'Mengubah pengumuman ' . $this->title
            ]);
            $data->save();
            $this->flash('success', 'Data berhasil disimpan', [], route('admin.pengumumans'));
        }
    }
}
