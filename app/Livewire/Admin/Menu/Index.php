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
    public $menuId;
    public $parentIdToMove;
    public $childrenToMove = [];

    public function getListeners()
    {
        return [
            'deleteMenu' => 'deleteMenu',
            'changeStatus' => 'changeStatus',
            'handleDelete' => 'handleDelete',
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
        return view('livewire.admin.menu.index', [
            'nestedMenus' => $nestedMenus,
            'pages' => $pages,
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'Menu']);
    }

    public function resetInput()
    {
        $this->type = null;
        $this->parent_id = null;
        $this->sort = null;
        $this->url = null;
        $this->title = null;
        $this->menuId = null;
        $this->updateMode = false;
        $this->parentIdToMove = null;
        $this->childrenToMove = [];
    }

    public function store()
    {
        try{
            $validate = $this->validate([
                'title' => 'required|unique:menus,title',
                'type' => 'required',
                'parent_id' => 'nullable|integer',
                'sort' => 'required|integer',
                'url' => 'nullable',
                'page_id' => 'nullable|exists:pages,id',
            ], [
                'title.required' => 'Nama menu tidak boleh kosong',
                'title.unique' => 'Nama menu sudah digunakan',
                'type.required' => 'Tipe menu tidak boleh kosong',
                'parent_id.integer' => 'Parent menu harus berupa angka',
                'sort.required' => 'Urutan menu tidak boleh kosong',
                'sort.integer' => 'Urutan menu harus berupa angka',
                'url.url' => 'URL tidak valid',
                'page_id.exists' => 'Halaman tidak valid',
            ]);

            if($validate){
                $data = new Menu();
                if ($this->type == 'page' && $this->page_id) {
                    $page = Page::find($this->page_id);
                    $data->page_id = $page->id;
                    $data->url = url('/') . '/page/' . $page->slug;
                } else {
                    $data->url = $this->url;
                }
                $data->type = $this->type;
                $data->parent_id = $this->parent_id;
                // jika parent_id sama sort tidak boleh sama dengan sort lainnya di parent_id yang sama,
                $checkSort = Menu::where('parent_id', $this->parent_id)->where('sort', $this->sort)->first();
                if ($checkSort != null) {
                    $this->alert('error', 'Urutan menu ' . $this->sort . ' sudah digunakan');
                } else {
                    $data->sort = $this->sort;
                }
                $data->title = $this->title;
                $data->slug = Str::slug($this->title);
                $data->save();

                LogUser::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Create',
                    'description' => 'Menambahkan menu ' . $this->title
                ]);

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
        $this->menuId = $menu->id;
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
                'title' => 'required|unique:menus,title,' . $this->menuId,
                'type' => 'required',
                'parent_id' => 'nullable|integer',
                'sort' => 'required|integer',
                'url' => 'nullable',
                'page_id' => 'nullable|exists:pages,id',
            ], [
                'title.required' => 'Nama menu tidak boleh kosong',
                'title.unique' => 'Nama menu sudah digunakan',
                'type.required' => 'Tipe menu tidak boleh kosong',
                'parent_id.integer' => 'Parent menu harus berupa angka',
                'sort.required' => 'Urutan menu tidak boleh kosong',
                'sort.integer' => 'Urutan menu harus berupa angka',
                'url.url' => 'URL tidak valid',
                'page_id.exists' => 'Halaman tidak valid',
            ]);

            if($validate && $this->updateMode == true){
                $data = Menu::find($this->menuId);
                if ($this->type == 'page' && $this->page_id) {
                    $page = Page::find($this->page_id);
                    $data->page_id = $page->id;
                    $data->url = url('/') . '/page/' . $page->slug;
                } else {
                    $data->url = $this->url;
                }
                $data->type = $this->type;
                $data->parent_id = $this->parent_id;
                $checkSort = Menu::where('parent_id', $this->parent_id)->where('sort', $this->sort)->first();
                if ($checkSort != null) {
                    $this->alert('error', 'Urutan menu ' . $this->sort . ' sudah digunakan');
                } else {
                    $data->sort = $this->sort;
                }
                $data->title = $this->title;
                $data->slug = Str::slug($this->title);
                $data->save();

                LogUser::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Update',
                    'description' => 'Mengubah menu ' . $this->title
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
        $this->data = Menu::findOrFail($id);
        if ($this->data->parent_id == 0 && Menu::where('parent_id', $this->data->id)->count() > 0) {
            $this->showMoveChildrenModal($id);
        } else {
            $this->confirm('Yakin ingin menghapus menu ini beserta submenu?', [
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'cancelButtonText' => 'Tidak',
                'onConfirmed' => 'handleDelete',
                'onCancelled' => 'cancelled'
            ]);
        }
    }

    public function handleDelete()
    {
        $this->data->delete();

        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Delete',
            'description' => 'Menghapus menu ' . $this->data->title
        ]);

        $this->alert('success', 'Menu berhasil dihapus');
    }

    public function showMoveChildrenModal($id)
    {
        $this->data = Menu::find($id);
        $this->childrenToMove = Menu::where('parent_id', $this->data->id)->get();
        $this->dispatch('show-move-children-modal');
    }

    public function moveChildrenAndDelete()
    {
        if ($this->parentIdToMove !== null) {
            foreach ($this->childrenToMove as $child) {
                $child->parent_id = $this->parentIdToMove;
                $child->save();
            }
        }

        $this->data->delete();

        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Delete',
            'description' => 'Menghapus menu ' . $this->data->title
        ]);

        $this->resetInput();
        $this->dispatch('close-move-children-modal');
        $this->alert('success', 'Menu dan submenu berhasil dipindahkan dan dihapus');
    }

    private function deleteMenuAndChildren($menuId)
    {
        $children = Menu::where('parent_id', $menuId)->get();
        foreach ($children as $child) {
            $this->deleteMenuAndChildren($child->id);
        }
        Menu::find($menuId)->delete();
    }

    public function status($id)
    {
        $this->data = Menu::findOrFail($id);
        $this->confirm('Yakin ingin mengubah status menu ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'changeStatus',
            'onCancelled' => 'cancelled'
        ]);
    }

    public function changeStatus()
    {
        try {
            if ($this->data->status == 'Draft') {
                $this->data->status = 'Publish';
            } else {
                $this->data->status = 'Draft';
            }
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Update',
                'description' => 'Mengubah status menu ' . $this->data->title . ' menjadi ' . $this->data->status
            ]);
            $this->data->save();
            $this->alert('success', 'Status berhasil diubah');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
