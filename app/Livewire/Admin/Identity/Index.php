<?php

namespace App\Livewire\Admin\Identity;

use App\Models\LogActivity\LogUser;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Utility\IdentityWeb;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithFileUploads, LivewireAlert;
    public $name_website, $heads_name, $moto, $description, $email, $address, $phone, $whatsapp, $facebook, $instagram, $twitter, $youtube, $map, $favicon, $logo, $prevFav, $prevLogo, $heads_photo, $prevHeadsPhoto;

    public function render()
    {
        return view('livewire.admin.identity.index', [])->layout('components.admin_layouts.app')->layoutData(['title' => 'Identity']);
    }

    public function mount()
    {
        $datas = IdentityWeb::first();
        if($datas != null){
            $this->name_website = $datas->name_website;
            $this->heads_name = $datas->heads_name;
            $this->moto = $datas->moto;
            $this->description = $datas->description;
            $this->email = $datas->email;
            $this->address = $datas->address;
            $this->phone = $datas->phone;
            $this->whatsapp = $datas->whatsapp;
            $this->facebook = $datas->facebook;
            $this->instagram = $datas->instagram;
            $this->twitter = $datas->twitter;
            $this->youtube = $datas->youtube;
            $this->map = $datas->map;
            $this->prevFav = $datas->favicon;
            $this->prevLogo = $datas->logo;
            $this->prevHeadsPhoto = $datas->heads_photo;
        }else{
            $this->name_website = '';
            $this->heads_name = '';
            $this->moto = '';
            $this->description = '';
            $this->email = '';
            $this->address = '';
            $this->phone = '';
            $this->whatsapp = '';
            $this->facebook = '';
            $this->instagram = '';
            $this->twitter = '';
            $this->youtube = '';
            $this->map = '';
            $this->prevFav = '';
            $this->prevLogo = '';
            $this->prevHeadsPhoto='';
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'name_website' => 'nullable',
                'heads_name' => 'nullable',
                'moto' => 'nullable',
                'description' => 'nullable',
                'email' => 'nullable',
                'address' => 'nullable',
                'phone' => 'nullable',
                'whatsapp' => 'nullable',
                'facebook' => 'nullable',
                'instagram' => 'nullable',
                'twitter' => 'nullable',
                'youtube' => 'nullable',
                'map' => 'nullable',
                'favicon' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'heads_photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            ], [
                'name_website.required' => 'Nama website tidak boleh kosong',
                'heads_name.required' => 'Nama pemilik tidak boleh kosong',
                'moto.required' => 'Moto tidak boleh kosong',
                'description.required' => 'Deskripsi tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'address.required' => 'Alamat tidak boleh kosong',
                'phone.required' => 'Nomor telepon tidak boleh kosong',
                'whatsapp.required' => 'Nomor whatsapp tidak boleh kosong',
                'facebook.required' => 'Link facebook tidak boleh kosong',
                'instagram.required' => 'Link instagram tidak boleh kosong',
                'twitter.required' => 'Link twitter tidak boleh kosong',
                'youtube.required' => 'Link youtube tidak boleh kosong',
                'map.required' => 'Link map tidak boleh kosong',
                'favicon.image' => 'Favicon harus berupa gambar',
                'favicon.mimes' => 'Favicon harus berupa gambar dengan format png, jpg, jpeg',
                'favicon.max' => 'Favicon tidak boleh lebih dari 2MB',
                'logo.image' => 'Logo harus berupa gambar',
                'logo.mimes' => 'Logo harus berupa gambar dengan format png, jpg, jpeg',
                'logo.max' => 'Logo tidak boleh lebih dari 2MB'
            ]);

            $datas = IdentityWeb::first();
            if ($datas) {
                $datas->name_website = $this->name_website;
                $datas->heads_name = $this->heads_name;
                $datas->moto = $this->moto;
                $datas->description = $this->description;
                $datas->email = $this->email;
                $datas->address = $this->address;
                $datas->phone = $this->phone;
                $datas->whatsapp = $this->whatsapp;
                $datas->facebook = $this->facebook;
                $datas->instagram = $this->instagram;
                $datas->twitter = $this->twitter;
                $datas->youtube = $this->youtube;
                $datas->map = $this->map;

                $destinationPath = public_path('storage/identitas/');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                if ($this->favicon) {
                    $fav = $this->favicon;
                    $favName = 'favicon_'.Str::slug($this->name_website).'.webp';
                    $image = imagecreatefromstring(file_get_contents($fav->getRealPath()));
                    imagewebp($image, $destinationPath.$favName, 90);
                    imagedestroy($image);
                    $datas->favicon = $favName;
                }

                if ($this->heads_photo) {
                    $head = $this->heads_photo;
                    $headName = 'heads_photo_'.Str::slug($this->name_website).'.webp';
                    $image = imagecreatefromstring(file_get_contents($head->getRealPath()));
                    imagewebp($image, $destinationPath.$headName, 90);
                    imagedestroy($image);
                    $datas->heads_photo = $headName;
                }

                if ($this->logo) {
                    $log = $this->logo;
                    $logName = 'logo_'.Str::slug($this->name_website).'.webp';
                    $image = imagecreatefromstring(file_get_contents($log->getRealPath()));
                    imagewebp($image, $destinationPath.$logName, 90);
                    imagedestroy($image);
                    $datas->logo = $logName;
                }
                LogUser::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Update',
                    'description' => 'Mengubah identitas website'
                ]);
                $datas->save();
                $this->alert('success', 'Data berhasil diupdate');
            } else {
                $this->alert('error', 'Data tidak ditemukan');
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
