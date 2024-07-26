<?php

namespace App\Livewire\Admin\Video;

use Livewire\Component;
use App\Models\Core\Video;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination,LivewireAlert;
    public $limit = 10;
    public $title, $description, $yt_id, $linkYoutube, $data, $dataId;
    public $updateMode = false;
    public $search = '';

    public function getListeners()
    {
        return [
            'deleteData' => 'deleteData',
            'changeStatus' => 'changeStatus',
        ];
    }

    public function filter()
    {

    }
    public function render()
    {
        // dd($this->search);
        $datas = Video::orderBy('created_at','ASC')->when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->paginate($this->limit);
        return view('livewire.admin.video.index',[
            'datas' => $datas
        ])->layout('components.admin_layouts.app')->layoutData([
            'title' => 'Video',
        ]);
    }

    public function resetInput()
    {
        $this->title = '';
        $this->description = '';
        $this->linkYoutube = '';
    }

    public function store()
    {
        try{
            $validate = $this->validate([
                'title' => 'required',
                'description' => 'required',
                'linkYoutube' => 'required',
            ],[
                'title.required' => 'Judul video tidak boleh kosong',
                'description.required' => 'Deskripsi video tidak boleh kosong',
                'linkYoutube.required' => 'Link youtube tidak boleh kosong',
            ]);

            if($validate && $this->updateMode == false){
                $url = $this->linkYoutube;
                parse_str(parse_url($url, PHP_URL_QUERY), $youtube);
                $linkYt = $youtube['v'];

                $data = new Video();
                $data->title = $this->title;
                $data->slug = Str::slug($this->title);
                $data->description = $this->description;
                $data->yt_id = $linkYt;
                $data->save();
                $this->dispatch('closeModal');
                $this->resetInput();
                $this->alert('success' , 'Data berhasil disimpan');
            }
        } catch (\Exception $e) {
            $this->alert('error' , $e->getMessage());
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = Video::find($id);
        $this->dataId = $id;
        $this->title = $data->title;
        $this->description = $data->description;
        $this->linkYoutube = 'https://www.youtube.com/watch?v=' . $data->yt_id;
    }

    public function update()
    {
        try{
            $validate = $this->validate([
                'title' => 'required',
                'description' => 'required',
                'linkYoutube' => 'required',
            ],[
                'title.required' => 'Judul video tidak boleh kosong',
                'description.required' => 'Deskripsi video tidak boleh kosong',
                'linkYoutube.required' => 'Link youtube tidak boleh kosong',
            ]);

            if($validate && $this->updateMode == true){
                $url = $this->linkYoutube;
                parse_str(parse_url($url, PHP_URL_QUERY), $youtube);
                $linkYt = $youtube['v'];

                $data = Video::find($this->dataId);
                $data->title = $this->title;
                $data->slug = Str::slug($this->title);
                $data->description = $this->description;
                $data->yt_id = $linkYt;
                $data->save();
                $this->resetInput();
                $this->dispatch('closeModal');
                $this->alert('success' , 'Data berhasil diupdate');
            }
        } catch (\Exception $e) {
            $this->alert('error' , $e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->confirm('Apakah anda yakin akan menghapus data ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'deleteData',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = Video::findOrfail($id);
    }

    public function deleteData()
    {
        try {
            $this->data->delete();
            $this->alert('success' , 'Data berhasil dihapus');
        } catch (\Exception $e) {
            $this->alert('error' , $e->getMessage());
        }
    }

    public function status($id)
    {
        $this->confirm('Apakah anda yakin akan mengubah status data ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'changeStatus',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = Video::findOrfail($id);
    }

    public function changeStatus()
    {
        try {
            if($this->data->status == 'Draft'){
                $this->data->status = 'Publish';
            }else{
                $this->data->status = 'Draft';
            }
            $this->data->save();
            $this->alert('success' , 'Status berhasil diubah');
        } catch (\Exception $e) {
            $this->alert('error' , $e->getMessage());
        }
    }
}
