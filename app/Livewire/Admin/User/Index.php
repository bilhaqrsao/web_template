<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use App\Models\Core\Store;
use App\Models\LogActivity\LogUser;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Index extends Component
{
    use WithPagination, LivewireAlert, WithFileUploads;
    public $search, $data;
    public $name, $username, $email, $password, $photo, $role, $store_id, $phone, $prevPhoto, $dataId;
    public $updateMode = false;

    public function getListeners()
    {
        return [
            'onConfirmedAction' => 'onConfirmedAction',
            'impersonateAction' => 'impersonateAction',
            'changeStatusAction' => 'changeStatusAction'
        ];
    }

    public function render()
    {
        // check username, jika developer tampilkan semua user, jika admin tampilkan user yang store_id sama dengan store_id user yang login
        if(auth()->user()->username == 'dev'){
            $users = User::latest()->when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
                $query->orWhere('username', 'like', '%'.$this->search.'%');
            })->paginate(10);
        }elseif(auth()->user()->name == 'Super Admin'){
            $users = User::where('username', '!=', 'dev')->where('username', '!=', 'sa')->when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
                $query->orWhere('username', 'like', '%'.$this->search.'%');
            })->latest()->paginate(10);
        }

        $userLogin = auth()->user();
        $roles = collect(); // Inisialisasi $roles dengan koleksi kosong sebagai default
        $stores = collect(); // Inisialisasi $stores dengan koleksi kosong sebagai default
        if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('developer')){
            $roles = Role::where('name', '!=', 'developer')->where('name', '!=', 'super-admin')->get();
        }elseif(auth()->user()->hasRole('admin')){
            $roles = Role::where('name', '!=', 'developer')->where('name', '!=', 'admin')->where('name', '!=', 'super-admin')->get();
        }
        return view('livewire.admin.user.index', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('components.admin_layouts.app')->layoutData([
            'title' => 'Users',
        ]);
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

         $this->data = User::query()->findOrFail($id);
    }

    public function onConfirmedAction()
    {
        if($this->data->photo){
            File::delete('storage/user/'.$this->data->photo);
        }
        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Delete',
            'description' => 'Menghapus user '.$this->data->name
        ]);
        $this->data->delete();
        // log activity
        if(auth()->user()->HasRole('super-admin')){
            $log = new LogUser();
            $log->user_id = auth()->user()->id;
            $log->activity = 'Super Admin menghapus pengguna, '.$this->data->name;
            $log->description = 'Pengguna dengan username '.$this->data->username.' berhasil dihapus';
            $log->save();
        }elseif(auth()->user()->HasRole('admin')){
            $log = new LogUser();
            $log->user_id = auth()->user()->id;
            $log->activity = 'Admin menghapus pengguna, '.$this->data->name;
            $log->description = 'Pengguna dengan username '.$this->data->username.' berhasil dihapus';
            $log->save();
        }
        $this->alert('success', 'Data berhasil dihapus');

    }

    public function impersonate($id)
    {
        $this->confirm('Apakah anda yakin?',[
            'text' => 'Mengimpersonate pengguna ini akan mengubah status semua data yang berhubungan dengan pengguna ini!',
            'icon' => 'warning',
            'showCancelButton' => true,
            'onConfirmed' => 'impersonateAction',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = User::query()->findOrFail($id);
    }

    public function impersonateAction()
    {
        if(auth()->user()->id == $this->data->id){
            $this->alert('error','Anda tidak bisa mengimpersonate akun anda sendiri');
         }elseif(auth()->user()->id != $this->data->id){
            auth()->user()->impersonate($this->data);
            $this->flash('success','Anda berhasil mengimpersonate akun '.$this->data->name,[],route('admin.dashboard'));
         }
    }

    public function changeStatus($id)
    {
       $this->confirm('Apakah anda yakin?',[
           'text' => 'Mengubah status pengguna ini akan mengubah status semua data yang berhubungan dengan pengguna ini!',
           'icon' => 'warning',
           'showCancelButton' => true,
           'onConfirmed' => 'changeStatusAction',
           'onCancelled' => 'cancelled'
       ]);

         $this->data = User::query()->findOrFail($id);
    }


    public function changeStatusAction()
    {
        if($this->data->status == 'Active'){
            $this->data->status = 'Inactive';
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Update',
                'description' => 'Mengubah status pengguna '.$this->data->name.' menjadi Inactive'
            ]);
            $this->data->save();
            // log activity
            if(auth()->user()->username == 'super-admin'){
                $log = new LogUser();
                $log->user_id = auth()->user()->id;
                $log->activity = 'Super Admin mengubah status pengguna, '.$this->data->name;
                if($this->data->status == 'Active'){
                    $log->description = 'Status pengguna dengan username '.$this->data->username.' berhasil diubah dari Inactive menjadi Active';
                }else{
                    $log->description = 'Status pengguna dengan username '.$this->data->username.' berhasil diubah dari Active menjadi Inactive';
                }
                $log->save();
            }elseif(auth()->user()->username == 'admin'){
                $log = new LogUser();
                $log->user_id = auth()->user()->id;
                $log->activity = 'Admin mengubah status pengguna, '.$this->data->name;
                if($this->data->status == 'Active'){
                    $log->description = 'Status pengguna dengan username '.$this->data->username.' berhasil diubah dari Inactive menjadi Active';
                }else{
                    $log->description = 'Status pengguna dengan username '.$this->data->username.' berhasil diubah dari Active menjadi Inactive';
                }
                $log->save();
            }
            $this->alert('success','Status pengguna berhasil diubah');

        }else{
            $this->data->status = 'Active';
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Update',
                'description' => 'Mengubah status pengguna '.$this->data->name.' menjadi Active'
            ]);
            $this->data->save();
            // log activity
            if(auth()->user()->HasRole('super-admin')){
                $log = new LogUser();
                $log->user_id = auth()->user()->id;
                $log->activity = 'Super Admin mengubah status pengguna, '.$this->data->name;
                if($this->data->status == 'Active'){
                    $log->description = 'Status pengguna dengan username '.$this->data->username.' berhasil diubah dari Inactive menjadi Active';
                }else{
                    $log->description = 'Status pengguna dengan username '.$this->data->username.' berhasil diubah dari Active menjadi Inactive';
                }
                $log->save();
            }elseif(auth()->user()->HasRole('admin')){
                $log = new LogUser();
                $log->user_id = auth()->user()->id;
                $log->activity = 'Admin mengubah status pengguna, '.$this->data->name;
                if($this->data->status == 'Active'){
                    $log->description = 'Status pengguna dengan username '.$this->data->username.' berhasil diubah dari Inactive menjadi Active';
                }else{
                    $log->description = 'Status pengguna dengan username '.$this->data->username.' berhasil diubah dari Active menjadi Inactive';
                }
                $log->save();
            }
            $this->alert('success','Status pengguna berhasil diubah');
        }
    }

    public function resetInput()
    {
            $this->name = '';
            $this->username = '';
            $this->email = '';
            $this->phone = '';
            $this->password = '';
            $this->photo = '';
            $this->role = '';
            $this->store_id = '';

    }

    public function store()
    {
        $updateMode = false;
        $validate = $this->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:8',
            'photo' => 'image',
            'role' => 'required',
            'store_id' => 'required'
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'phone.required' => 'Phone tidak boleh kosong',
            'phone.unique' => 'Phone sudah digunakan',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'photo.image' => 'Photo harus berupa gambar',
            'role.required' => 'Role tidak boleh kosong',
            'store_id.required' => 'Toko tidak boleh kosong'
        ]);

        if($validate && $updateMode == false){
            $data = new User();
            $data->name = $this->name;
            $data->username = $this->username;
            $data->email = $this->email;
            $data->phone = $this->phone;
            $data->password = Hash::make($this->password);
            $data->assignRole($this->role);
            if($this->photo){
                $image = $this->photo;
                $imageName = 'user-'.time().'.'.$image->extension();
                $destinationPath = public_path('storage/user/');
                $img = Image::make($image->getRealPath());
                $QuploadImage = $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . $imageName, 100);
                $data->photo = $imageName;
            }
            $data->status = 'Active';
            $data->save();
            $this->alert('success','Data berhasil ditambahkan');
            $this->resetInput();
            // emit close modal
            $this->dispatch('closeModal');

            // log activity
            if(auth()->user()->HasRole('super-admin')){
                $log = new LogUser();
                $log->user_id = auth()->user()->id;
                $log->activity = 'Super Admin menambahkan pengguna baru, '.$data->name;
                $log->description = 'Pengguna baru dengan username '.$data->username.' berhasil ditambahkan';
                $log->save();
            }elseif(auth()->user()->HasRole('admin')){
                $log = new LogUser();
                $log->user_id = auth()->user()->id;
                $log->activity = 'Admin menambahkan pengguna baru, '.$data->name;
                $log->description = 'Pengguna baru dengan username '.$data->username.' berhasil ditambahkan';
                $log->save();
            }

        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = User::query()->findOrFail($id);
        $this->dataId = $data->id;
        $this->name = $data->name;
        $this->username = $data->username;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->role = $data->role;
        $this->prevPhoto = $data->photo;
    }

    public function update()
    {
        $updateMode = true;
        $validate = $this->validate([
            'name' => 'nullable',
            'username' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'password' => 'nullable|min:8',
            'photo' => 'nullable|image',
            'role' => 'nullable',
            'store_id' => 'nullable'
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'phone.required' => 'Phone tidak boleh kosong',
            'phone.unique' => 'Phone sudah digunakan',
            'password.min' => 'Password minimal 8 karakter',
            'photo.image' => 'Photo harus berupa gambar',
            'role.required' => 'Role tidak boleh kosong',
            'store_id.required' => 'Toko tidak boleh kosong'
        ]);

        if($validate && $updateMode == true){
            $data = User::query()->findOrFail($this->dataId);
            $data->name = $this->name;
            $data->username = $this->username;
            $data->email = $this->email;
            $data->phone = $this->phone;
            if($this->password){
                $data->password = Hash::make($this->password);
            }
            $data->assignRole($this->role);
            if($this->photo){
                if($data->photo){
                    File::delete('storage/user/'.$data->photo);
                }
                $image = $this->photo;
                $imageName = 'user-'.time().'.'.$image->extension();
                $destinationPath = public_path('storage/user/');
                $img = Image::make($image->getRealPath());
                $QuploadImage = $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . $imageName, 100);
                $data->photo = $imageName;
            }
            $data->status = 'Active';
            $data->save();
            $this->alert('success','Data berhasil diubah');
            $this->resetInput();
            // emit close modal
            $this->dispatch('closeModal');

            // log activity
            if(auth()->user()->HasRole('super-admin')){
                $log = new LogUser();
                $log->user_id = auth()->user()->id;
                $log->activity = 'Super Admin mengubah data pengguna, '.$data->name;
                $log->description = 'Data pengguna dengan username '.$data->username.' berhasil diubah';
                $log->save();
            }elseif(auth()->user()->HasRole('admin')){
                $log = new LogUser();
                $log->user_id = auth()->user()->id;
                $log->activity = 'Admin mengubah data pengguna, '.$data->name;
                $log->description = 'Data pengguna dengan username '.$data->username.' berhasil diubah';
                $log->save();
            }
        }
    }

}
