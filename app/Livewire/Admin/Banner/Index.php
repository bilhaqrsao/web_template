<?php

namespace App\Livewire\Admin\Banner;

use Livewire\Component;
use App\Models\Core\Banner;
use App\Models\LogActivity\LogUser;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination,WithFileUploads, LivewireAlert;
    public $title, $images, $data;
    public $search;

    public function getListeners()
    {
        return [
            'deleteConfirmed' => 'deleteConfirmed',
        ];
    }

    public function render()
    {
        $datas = Banner::orderBy('created_at','DESC')->when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->get();
        return view('livewire.admin.banner.index',[
            'datas' => $datas
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Banner']);
    }

    public function resetInput()
    {
        $this->title = '';
        $this->images = '';
    }

    public function store()
    {
        try {
            $validate = $this->validate([
                'title' => 'required',
                'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ],[
                'title.required' => 'Title tidak boleh kosong',
                'images.required' => 'Images tidak boleh kosong',
                'images.image' => 'Images harus berupa gambar',
                'images.mimes' => 'Images harus berupa gambar dengan format jpeg,png,jpg,gif,svg',
            ]);

            if($validate){
                $data = new Banner();
                $data->title = $this->title;

                $destinationPath = public_path('storage/banner/');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                if($this->images){
                    $image = $this->images;
                    $imageName = Str::slug($this->title).'.webp';
                    $img = imagecreatefromstring(file_get_contents($image->getRealPath()));
                    imagewebp($img, $destinationPath.$imageName, 90);
                    imagedestroy($img);
                    $data->images = $imageName;
                }

                LogUser::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Create',
                    'description' => 'Menambahkan gambar banner '.$this->title
                ]);
                $data->save();
                $this->alert('success', 'Data has been saved successfully');
                $this->resetInput();
                $this->dispatch('closeModal');
            }

        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->confirm('Apakah anda akan menghapus data ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'deleteConfirmed',
            'onCancelled' => 'deleteCancelled',
        ]);

        $this->data = Banner::findOrfail($id);
    }

    public function deleteConfirmed()
    {
        if($this->data->images){
            $destinationPath = public_path('storage/banner/');
            File::delete($destinationPath.$this->data->images);
        }

        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Delete',
            'description' => 'Menghapus gambar banner '.$this->data->title
        ]);
        $this->data->delete();
        $this->alert('success', 'Data has been deleted successfully');
    }
}
