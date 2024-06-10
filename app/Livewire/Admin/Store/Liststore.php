<?php

namespace App\Livewire\Admin\Store;

use Livewire\Component;
use App\Models\Core\Store;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Liststore extends Component
{
    use WithPagination, LivewireAlert, WithFileUploads;
    public $search, $data;
    public $banner, $name, $description, $email, $phone, $address, $city, $state, $country, $logo, $website, $facebook, $twitter, $instagram, $slug, $dataId, $prevBanner, $prevLogo;
    public $updateMode = false;
    public $paginate = 12;

    public function getListeners()
    {
        return [
            'onConfirmedAction' => 'onConfirmedAction',
        ];
    }

    public function render()
    {
        $datas = Store::when($this->search, function($query) {
            $query->where('name', 'like', '%'.$this->search.'%');
        })->paginate($this->paginate);

        $user = auth()->user();

        return view('livewire.admin.store.liststore',[
            'datas' => $datas,
            'user' => $user
        ])->layout('components.admin_layouts.app');
    }

    public function destroy($id)
    {
        $this->confirm('Apakah anda yakin?', [
            'text' => 'Data yang dihapus tidak dapat dikembalikan!',
            'icon' => 'warning',
            'showCancelButton' => true,
            'onConfirmed' => 'onConfirmedAction',
            'onCancelled' => 'cancelled'
         ]);

         $this->data = Store::query()->findOrFail($id);
    }

    public function onConfirmedAction()
    {
        if($this->data->banner){
            File::delete('storage/store/banner/'.$this->data->banner);
        }
        if($this->data->logo){
            File::delete('storage/store/logo/'.$this->data->logo);
        }
        $this->data->delete();
        $this->alert('success', 'Data berhasil dihapus');
    }

    public function resetInput()
    {
        $this->banner = '';
        $this->name = '';
        $this->description = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->city = '';
        $this->state = '';
        $this->country = '';
        $this->logo = '';
        $this->website = '';
        $this->facebook = '';
        $this->twitter = '';
        $this->instagram = '';
    }

    public function store()
    {
        $updateMode = false;
        $validate = $this->validate([
            'banner' => 'required|image|mimes:jpeg,png,jpg',
            'name' => 'required',
            'description' => 'nullable',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'nullable',
            'country' => 'nullable',
            'logo' => 'required|image|mimes:jpeg,png,jpg',
            'website' => 'nullable',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'instagram' => 'nullable',
        ],[
            // bahasa indonesia
            'banner.required' => 'Banner tidak boleh kosong',
            'banner.image' => 'Banner harus berupa gambar',
            'banner.mimes' => 'Banner harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email harus berupa email',
            'phone.required' => 'Telepon tidak boleh kosong',
            'address.required' => 'Alamat tidak boleh kosong',
            'city.required' => 'Kota tidak boleh kosong',
            'state.required' => 'Provinsi tidak boleh kosong',
            'country.required' => 'Negara tidak boleh kosong',
            'logo.required' => 'Logo tidak boleh kosong',
            'logo.image' => 'Logo harus berupa gambar',
            'logo.mimes' => 'Logo harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
            'logo.max' => 'Logo maksimal 2MB',
        ]);

        if($validate && $updateMode == false){
            $data = new Store();
            $data->name = $this->name;
            $data->slug = Str::slug($this->name) . '-' . Str::random(5);
            if ($this->banner) {
                $banner = $this->banner;
                $imageName = time() . '.' . $banner->getClientOriginalExtension();
                $destinationPath = public_path('/storage/store/banner/');
                $img = Image::make($banner->getRealPath());
                $QuploadImage = $img->resize(540, 540, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . $imageName, 100);

                $data->banner = $imageName;
            }
            $data->description = $this->description;
            $data->email = $this->email;
            $data->phone = $this->phone;
            $data->address = $this->address;
            $data->city = $this->city;
            $data->state = $this->state;
            $data->country = $this->country;
            if ($this->logo) {
                $logo = $this->logo;
                $imageName = time() . '.' . $logo->getClientOriginalExtension();
                $destinationPath = public_path('/storage/store/logo/');
                $img = Image::make($logo->getRealPath());
                $QuploadImage = $img->resize(540, 540, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . $imageName, 100);

                $data->logo = $imageName;
            }
            $data->website = $this->website;
            $data->facebook = 'https://www.facebook.com/'.$this->facebook; // tambahkan 'https://www.facebook.com/'
            $data->twitter = 'https://www.twitter.com/'.$this->twitter; // tambahkan 'https://www.twitter.com/'
            $data->instagram = 'https://www.instagram.com/'.$this->instagram; // tambahkan 'https://www.instagram.com/'
            $data->save();
            $this->alert('success', 'Data berhasil disimpan');
            $this->resetInput();
            $this->dispatch('closeModal');
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = Store::query()->findOrFail($id);
        $this->dataId = $id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->address = $data->address;
        $this->city = $data->city;
        $this->state = $data->state;
        $this->country = $data->country;
        $this->website = $data->website;
        $this->facebook = $data->facebook;
        $this->twitter = $data->twitter;
        $this->instagram = $data->instagram;

        $this->prevBanner = $data->banner;
        $this->prevLogo = $data->logo;
    }

    public function update()
    {
        $updateMode = true;
        $validate = $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'nullable',
            'country' => 'nullable',
            'website' => 'nullable',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'instagram' => 'nullable',
        ],[
            // bahasa indonesia
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email harus berupa email',
            'phone.required' => 'Telepon tidak boleh kosong',
            'address.required' => 'Alamat tidak boleh kosong',
            'city.required' => 'Kota tidak boleh kosong',
            'state.required' => 'Provinsi tidak boleh kosong',
            'country.required' => 'Negara tidak boleh kosong',
        ]);

        if($validate && $updateMode == true){
            $data = Store::query()->findOrFail($this->dataId);
            $data->name = $this->name;
            $data->slug = Str::slug($this->name) . '-' . Str::random(5);
            if ($this->banner) {
                if($this->prevBanner){
                    File::delete('storage/store/banner/'.$this->prevBanner);
                }
                $banner = $this->banner;
                $imageName = time() . '.' . $banner->getClientOriginalExtension();
                $destinationPath = public_path('/storage/store/banner/');
                $img = Image::make($banner->getRealPath());
                $QuploadImage = $img->resize(540, 540, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . $imageName, 100);

                $data->banner = $imageName;
            }
            $data->description = $this->description;
            $data->email = $this->email;
            $data->phone = $this->phone;
            $data->address = $this->address;
            $data->city = $this->city;
            $data->state = $this->state;
            $data->country = $this->country;
            if ($this->logo) {
                if($this->prevLogo){
                    File::delete('storage/store/logo/'.$this->prevLogo);
                }
                $logo = $this->logo;
                $imageName = time() . '.' . $logo->getClientOriginalExtension();
                $destinationPath = public_path('/storage/store/logo/');
                $img = Image::make($logo->getRealPath());
                $QuploadImage = $img->resize(540, 540, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . $imageName, 100);

                $data->logo = $imageName;
            }
            $data->website = $this->website;
            $data->facebook = 'https://www.facebook.com/'.$this->facebook; // tambahkan 'https://www.facebook.com/'
            $data->twitter = 'https://www.twitter.com/'.$this->twitter; // tambahkan 'https://www.twitter.com/'
            $data->instagram = 'https://www.instagram.com/'.$this->instagram; // tambahkan 'https://www.instagram.com/'
            $data->save();
            $this->alert('success', 'Data berhasil diupdate');
            $this->resetInput();
            $this->dispatch('closeModal');
        }
    }



}
