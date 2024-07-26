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

class Create extends Component
{
    use LivewireAlert, WithFileUploads;
    public $title, $content, $image, $tags, $created_at;

    public function render()
    {
        $existingTags = Tag::get();
        return view('livewire.admin.pengumuman.create',[
            'existingTags' => $existingTags,
        ])->layout('components.admin_layouts.app')->layoutData([
            'title' => 'Buat Pengumuman',
        ]);
    }

    public function store()
    {
        try{
            $validate = $this->validate([
                'title' => 'required',
                'content' => 'required',
                'image' => 'image',
            ],[
                'title.required' => 'Judul tidak boleh kosong',
                'content.required' => 'Konten tidak boleh kosong',
                'image.image' => 'File harus berupa gambar',
            ]);

            if($validate){
                $data = new Pengumuman();
                $data->title = $this->title;
                $data->slug = Str::slug($this->title);
                $data->created_at = $this->created_at;
                $data->user_id = auth()->user()->id;
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
                if($this->image){
                    $imgName = Str::slug($this->title) . '.webp';
                    $img = imagecreatefromstring(file_get_contents($this->image->getRealPath()));
                    $destinationPath = public_path('storage/pengumuman');
                    if(!file_exists($destinationPath)){
                        mkdir($destinationPath, 0755, true);
                    }
                    imagewebp($img, $destinationPath . '/' . $imgName, 80);
                    $data->image = $imgName;
                }
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
                    'activity' => 'Create',
                    'description' => 'Menambahkan pengumuman ' . $this->title
                ]);
                $data->save();
                $this->flash('success', 'Data berhasil disimpan', [], route('admin.pengumumans'));
            }
        } catch(\Exception $e){
            $this->alert('error', $e->getMessage());
        }
    }
}
