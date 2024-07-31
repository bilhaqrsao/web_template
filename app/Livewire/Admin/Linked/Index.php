<?php

namespace App\Livewire\Admin\Linked;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Core\LinkTerkait;
use App\Models\LogActivity\LogUser;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert, WithFileUploads;
    public $limit = 10;
    public $updateMode = false;
    public $title, $url, $icon, $data_id, $prevIcon, $data;

    public function getListeners()
    {
        return [
            'deleteData' => 'deleteData',
        ];
    }

    public function render()
    {
        $datas = LinkTerkait::latest()->paginate($this->limit);
        return view('livewire.admin.linked.index',[
            'datas' => $datas
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Link TErkait']);
    }

    public function resetInput()
    {
        $this->title = '';
        $this->url = '';
        $this->icon = '';
        $this->updateMode = false;
    }

    public function store()
    {
        try{
            $validate = $this->validate([
                'title' => 'required',
                'url' => 'required',
                'icon' => 'required'
            ],[
                'title.required' => 'Judul tidak boleh kosong',
                'url.required' => 'URL tidak boleh kosong',
                'icon.required' => 'Icon tidak boleh kosong'
            ]);

            if($validate){
                $this->url = $this->addHttps($this->url);
                $data = new LinkTerkait();
                $data->title = $this->title;
                $data->slug = Str::slug($this->title);
                $data->url = $this->url;
                if($this->icon){
                    $iconName = Str::slug($this->title) . '.webp';
                    $icn = imagecreatefromstring(file_get_contents($this->icon->getRealPath()));
                    $destinationPath = public_path('storage/link-terkait');
                    if(!file_exists($destinationPath)){
                        mkdir($destinationPath, 0755, true);
                    }
                   imagewebp($icn, $destinationPath . '/' . $iconName);
                    $data->icon = $iconName;
                }
                LogUser::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Create',
                    'description' => 'Menambahkan data link terkait ' . $this->title,
                ]);
                $data->save();
                $this->alert('success', 'Data berhasil disimpan');
                $this->resetInput();
                $this->dispatch('closeModal');
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = LinkTerkait::find($id);
        $this->data_id = $id;
        $this->title = $data->title;
        $this->url = $data->url;
        $this->prevIcon = $data->icon;
    }

    public function update()
    {
        try{
            $validate = $this->validate([
                'title' => 'required',
                'url' => 'required',
                'icon' => 'required'
            ],[
                'title.required' => 'Judul tidak boleh kosong',
                'url.required' => 'URL tidak boleh kosong',
                'icon.required' => 'Icon tidak boleh kosong'
            ]);

            if($validate){
                $this->url = $this->addHttps($this->url);
                $data = LinkTerkait::find($this->data_id);
                $data->title = $this->title;
                $data->slug = Str::slug($this->title);
                $data->url = $this->url;
                // delete old icon and replace with new icon
                if($this->icon){
                    $destinationPath = public_path('/storage/link-terkait');
                    if(file_exists(public_path($destinationPath . '/' . $this->prevIcon))){
                        unlink(public_path($destinationPath . '/' . $this->prevIcon));
                    }
                    $iconName = Str::slug($this->title) . '.webp';
                    $icn = imagecreatefromstring(file_get_contents($this->icon->getRealPath()));
                    $destinationPath = public_path('storage/link-terkait');
                    if(!file_exists($destinationPath)){
                        mkdir($destinationPath, 0755, true);
                    }
                    imagewebp($icn, $destinationPath . '/' . $iconName);
                    $data->icon = $iconName;
                }
                LogUser::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Update',
                    'description' => 'Mengupdate data link terkait ' . $this->title,
                ]);
                $data->save();
                $this->alert('success', 'Data berhasil diupdate');
                $this->resetInput();
                $this->dispatch('closeModal');
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    private function addHttps($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "https://" . $url;
        }
        return $url;
    }

    public function delete($id)
    {
        $this->confirm('Yakin ingin menghapus data ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'deleteData',
            'onCancelled' => 'cancelled'
        ]);
        $this->data = LinkTerkait::findOrFail($id);
    }

    public function deleteData()
    {
        // delete icon from storage
        $destinationPath = public_path('/storage/link-terkait');
        if(file_exists(public_path($destinationPath . '/' . $this->data->icon))){
            unlink(public_path($destinationPath . '/' . $this->data->icon));
        }
        // delete data from database
        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Delete',
            'description' => 'Menghapus data link terkait ' . $this->data->title,
        ]);
        $this->data->delete();
        $this->alert('success', 'Data berhasil dihapus');
    }


}
