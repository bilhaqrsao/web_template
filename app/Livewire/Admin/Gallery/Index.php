<?php

namespace App\Livewire\Admin\Gallery;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Core\Gallery;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\LogActivity\LogUser;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithFileUploads, WithPagination, LivewireAlert;

    public $limit = 10;
    public $search, $title, $description, $images = [], $data, $removedImages = [];
    public $existingImages = [];
    public $updateMode = false;

    public function getListeners()
    {
        return [
            'deleteData' => 'deleteData',
            'changeStatus' => 'changeStatus',
        ];
    }

    public function render()
    {
        $datas = Gallery::orderBy('created_at','ASC')->when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->paginate($this->limit);

        return view('livewire.admin.gallery.index', [
            'datas' => $datas
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Galeri']);
    }

    public function resetInput()
    {
        $this->title = '';
        $this->description = '';
        $this->images = [];
        $this->existingImages = [];
        $this->removedImages = [];
        $this->updateMode = false;
    }

    public function store()
    {
        try {
            $this->validate([
                'title' => 'required',
                'description' => 'nullable',
                'images.*' => 'image|max:1024',
            ],[
                'title.required' => 'Judul tidak boleh kosong',
                'description.required' => 'Deskripsi tidak boleh kosong',
                'images.*.image' => 'File harus berupa gambar',
                'images.*.max' => 'Ukuran gambar maksimal 1MB',
            ]);

            if (!$this->updateMode) {
                $data = new Gallery();
                $data->title = $this->title;
                $data->slug = Str::slug($this->title);
                $data->description = $this->description;
                $data->user_id = auth()->user()->id;
                if ($this->images) {
                    $imageNames = [];
                    $destinationPath = public_path('storage/gallery');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    foreach ($this->images as $image) {
                        $imageName = 'gallery-' . Str::random(5) . '.webp';
                        $img = imagecreatefromstring(file_get_contents($image->getRealPath()));
                        imagewebp($img, $destinationPath . '/' . $imageName, 80);
                        imagedestroy($img);  // Release memory
                        $imageNames[] = $imageName;
                    }
                    $data->images = json_encode($imageNames);
                }

                LogUser::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Create',
                    'description' => 'Menambahkan galeri ' . $this->title
                ]);
                $data->save();
                $this->dispatch('closeModal');
                $this->resetInput();
                $this->alert('success', 'Gallery item successfully added!');
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function removeImage($index, $isExisting = false)
    {
        if ($isExisting) {
            $this->removedImages[] = $this->existingImages[$index]; // Track removed images
            unset($this->existingImages[$index]);
        } else {
            array_splice($this->images, $index, 1);
        }

        // Reindex arrays to fix key issues
        $this->existingImages = array_values($this->existingImages);
        $this->images = array_values($this->images);
    }

    public function edit($id)
    {
        try {
            $this->updateMode = true;
            $this->data = Gallery::findOrFail($id);
            $this->title = $this->data->title;
            $this->description = $this->data->description;
            $this->existingImages = json_decode($this->data->images, true);
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'title' => 'required',
                'description' => 'nullable',
                'images.*' => 'image|max:1024',
            ],[
                'title.required' => 'Judul tidak boleh kosong',
                'description.required' => 'Deskripsi tidak boleh kosong',
                'images.*.image' => 'File harus berupa gambar',
                'images.*.max' => 'Ukuran gambar maksimal 1MB',
            ]);

            $this->data->title = $this->title;
            $this->data->slug = Str::slug($this->title);
            $this->data->description = $this->description;

            $imageNames = $this->existingImages;
            $destinationPath = public_path('storage/gallery');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($this->images as $image) {
                $imageName = 'gallery-' . Str::random(5) . '.webp';
                $img = imagecreatefromstring(file_get_contents($image->getRealPath()));
                imagewebp($img, $destinationPath . '/' . $imageName, 80);
                imagedestroy($img);  // Release memory
                $imageNames[] = $imageName;
            }

            // Remove images from filesystem
            foreach ($this->removedImages as $removedImage) {
                $imagePath = public_path('storage/gallery/' . $removedImage);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $this->data->images = json_encode(array_values($imageNames));
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Update',
                'description' => 'Mengubah galeri ' . $this->title
            ]);
            $this->data->save();
            $this->dispatch('closeModal');
            $this->resetInput();
            $this->alert('success', 'Gallery item successfully updated!');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->confirm('Apakah Anda yakin ingin menghapus item ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'deleteData',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = Gallery::findOrFail($id);
    }

    public function deleteData()
    {
        try {
            // delete with all images
            $images = json_decode($this->data->images);
            foreach ($images as $image) {
                $imagePath = public_path('storage/gallery/' . $image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Delete',
                'description' => 'Menghapus galeri ' . $this->data->title
            ]);
            $this->data->delete();
            $this->alert('success', 'Gallery item successfully deleted!');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function status($id)
    {
        $this->confirm('Apakah Anda yakin ingin mengubah status item ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'changeStatus',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = Gallery::findOrFail($id);
    }

    public function changeStatus()
    {
        try {
            $this->data->status = $this->data->status == 'Publish' ? 'Draft' : 'Publish';
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Update',
                'description' => 'Mengubah status galeri ' . $this->data->title
            ]);
            $this->data->save();
            $this->alert('success', 'Gallery item status successfully changed!');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
