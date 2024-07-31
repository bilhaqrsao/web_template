<?php

namespace App\Livewire\Admin\Pengumuman;

use Livewire\Component;
use App\Models\Utility\Tag;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Core\Pengumuman;
use App\Models\Utility\PivotTags;
use App\Models\LogActivity\LogUser;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert, WithFileUploads;
    public $title, $content, $image, $created_at;
     public $tags = [];

    public function render()
    {
        $existingTags = Tag::get();
        return view('livewire.admin.pengumuman.create',[
            'existingTags' => $existingTags,
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Buat Pengumuman']);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ], [
            'title.required' => 'Judul tidak boleh kosong',
            'content.required' => 'Konten tidak boleh kosong',
            'image.image' => 'File harus berupa gambar',
        ]);

        try {
            $data = new Pengumuman();
            $data->title = $this->title;
            $data->slug = Str::slug($this->title);

            // Pastikan slug unik
            $originalSlug = $data->slug;
            $counter = 1;
            while (Pengumuman::where('slug', $data->slug)->exists()) {
                $data->slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $data->created_at = $this->created_at ?? now();
            $data->user_id = auth()->user()->id;

            // Proses gambar konten
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
                    $filepath = "storage/pengumuman/{$filename}.{$mimetype}";
                    $image = Image::make($dataImg)->encode($mimetype, 75);
                    $image->save(public_path($filepath));
                    $img->removeAttribute('src');
                    $img->setAttribute('src', asset($filepath));
                }
            }
            $data->content = $dom->saveHTML();

            // Proses gambar utama
            if ($this->image) {
                $imgName = Str::slug($this->title) . '.webp';
                $img = Image::make($this->image->getRealPath())->encode('webp', 80);
                $destinationPath = public_path('storage/pengumuman');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $img->save($destinationPath . '/' . $imgName);
                $data->image = $imgName;
            }

            // Simpan data terlebih dahulu untuk mendapatkan ID
            $data->save();

            // Handle tags setelah data disimpan
            foreach ($this->tags as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );

                PivotTags::updateOrCreate(
                    [
                        'taggable_type' => 'pengumuman',
                        'taggable_id' => $data->id, // Pastikan ini terisi
                        'tag_id' => $tag->id,
                    ]
                );
            }

            // Log activity
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Create',
                'description' => 'Menambahkan pengumuman ' . $this->title
            ]);

            // Redirect dan flash message
            $this->flash('success', 'Data berhasil disimpan');
            return redirect()->route('admin.pengumumans');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

}
