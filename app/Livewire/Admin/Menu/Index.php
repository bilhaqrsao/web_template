<?php

namespace App\Livewire\Admin\Menu;

use Livewire\Component;
use App\Models\Core\Page;
use Illuminate\Support\Str;
use App\Models\Utility\Menu;
use Livewire\WithFileUploads;
use App\Models\LogActivity\LogUser;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithFileUploads, LivewireAlert;

    public $updateMode = false;
    public $type, $parent_id, $sort, $url, $title, $page_id, $data;
    public $search;
    public $limit = 10;

    public function getListeners()
    {
        return [
            'deleteMenu' => 'deleteMenu',
            'changeStatus' => 'changeStatus',
        ];
    }

    public function getNestedMenus($menus, $parent_id = null)
    {
        $result = [];
        foreach ($menus as $menu) {
            if ($menu->parent_id == $parent_id) {
                $menu->children = $this->getNestedMenus($menus, $menu->id);
                $result[] = $menu;
            }
        }
        return $result;
    }

    public function render()
    {
        $menus = Menu::orderBy('sort', 'ASC')->get();
        $nestedMenus = $this->getNestedMenus($menus);
        $pages = Page::orderBy('created_at', 'DESC')->get();
        return view('livewire.admin.menu.index',[
            'nestedMenus' => $nestedMenus,
            'pages' => $pages,
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Menu']);
    }

    public function resetInput()
    {
        $this->type = '';
        $this->parent_id = '';
        $this->sort = '';
        $this->url = '';
        $this->title = '';
    }

    public function store()
    {
        try {
            $validate = $this->validate([
                'title' => 'required',
                'type' => 'required',
                'parent_id' => 'required',
                'sort' => 'required',
            ],[
                'title.required' => 'Nama menu tidak boleh kosong',
                'type.required' => 'Tipe menu tidak boleh kosong',
                'parent_id.required' => 'Parent menu tidak boleh kosong',
                'sort.required' => 'Urutan menu tidak boleh kosong',
            ]);

            if($validate && $this->updateMode == false){
                $data = new Menu();
                if($this->type == 'page'){
                    $page = Page::find($this->page_id);
                    $data->page_id = $page->id;
                    $data->url = url('/').'/page/'.$page->slug;
                }
                $data->type = $this->type;
                $data->parent_id = $this->parent_id;
                $data->sort = $this->sort;
                $data->url = $this->url;
                $data->title = $this->title;
                $data->slug = Str::slug($this->title);
                LogUser::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Create',
                    'description' => 'Menambahkan menu '.$this->title
                ]);
                $data->save();
                $this->resetInput();
                $this->dispatch('closeModal');
                $this->alert('success', 'Menu berhasil ditambahkan');
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        $this->type = $menu->type;
        $this->parent_id = $menu->parent_id;
        $this->sort = $menu->sort;
        $this->url = $menu->url;
        $this->title = $menu->title;
        $this->page_id = $menu->page_id;
        $this->updateMode = true;
    }

    public function update()
    {
        try {
            $validate = $this->validate([
                'title' => 'required',
                'type' => 'required',
                'parent_id' => 'required',
                'sort' => 'required',
            ],[
                'title.required' => 'Nama menu tidak boleh kosong',
                'type.required' => 'Tipe menu tidak boleh kosong',
                'parent_id.required' => 'Parent menu tidak boleh kosong',
                'sort.required' => 'Urutan menu tidak boleh kosong',
            ]);

            if($validate && $this->updateMode == true){
                $data = Menu::find($this->id);
                if($this->type == 'page'){
                    $page = Page::find($this->page_id);
                    $data->page_id = $page->id;
                    $data->url = url('/').'/page/'.$page->slug;
                }
                $data->type = $this->type;
                $data->parent_id = $this->parent_id;
                $data->sort = $this->sort;
                $data->url = $this->url;
                $data->title = $this->title;
                $data->save();
                LogUser::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Update',
                    'description' => 'Mengubah menu '.$this->title
                ]);
                $this->resetInput();
                $this->dispatch('closeModal');
                $this->alert('success', 'Menu berhasil diupdate');
            }
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->confirm('Yakin ingin menghapus menu ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'deleteMenu',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = Menu::query()->findOrFail($id);
    }

    public function deleteMenu()
    {
        try{
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Delete',
                'description' => 'Menghapus menu '.$this->data->title
            ]);
            $this->data->delete();
            $this->alert('success', 'Menu berhasil dihapus');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function status($id)
    {
        $this->confirm('Yakin ingin mengubah status menu ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'changeStatus',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = Menu::findOrFail($id);
    }

    public function changeStatus()
    {
        try{
            if($this->data->status == 'Draft'){
                $this->data->status = 'Publish';
            }else{
                $this->data->status = 'Draft';
            }
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Update',
                'description' => 'Mengubah status menu '.$this->data->title.' menjadi '.$this->data->status
            ]);
            $this->data->save();
            $this->alert('success', 'Status berhasil diubah');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

}
