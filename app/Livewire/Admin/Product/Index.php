<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Core\Product;
use Livewire\WithPagination;
use App\Models\Core\Category;
use Livewire\WithFileUploads;
use App\Models\Core\SubCategory;
use App\Models\LogActivity\LogStore;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination,LivewireAlert,WithFileUploads;
    public $name, $price, $category_id, $sub_category_id, $description, $image, $stock, $status, $store_id, $google_id;
    public $dataId, $data;
    public $prevImage = [];

    public $search;
    public $updateMode = false;

    public function getListeners()
    {
        return [
            'onConfirmedAction' => 'onConfirmedAction',
        ];
    }

    public function render()
    {
        $store_id = auth()->user()->store_id;

        // get inventory data
        $datas = Product::where('store_id', $store_id)->when($this->search, function($query){
            $query->where('name', 'like', '%'.$this->search.'%');
        })->paginate(10);

        $categries = Category::all();
        $subcategories = SubCategory::all();
        return view('livewire.admin.product.index',[
            'datas' => $datas,
            'categories' => $categries,
            'subcategories' => $subcategories
        ])->layout('components.admin_layouts.app');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->price = '';
        $this->category_id = '';
        $this->sub_category_id = '';
        $this->description = '';
        $this->image = '';
        $this->stock = '';
        $this->status = '';
        $this->store_id = '';
        $this->google_id = '';
    }

    public function store()
    {
        $updateMode = false;

        $validate = $this->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'description' => 'required',
            'image' => 'required|array|min:1', // Ubah validasi image menjadi array dan minimal satu gambar
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi tiap gambar
            'stock' => 'required',
        ],[
            // Pesan validasi bahasa Indonesia
            'name.required' => 'Nama produk wajib diisi',
            'price.required' => 'Harga produk wajib diisi',
            'category_id.required' => 'Kategori produk wajib diisi',
            'sub_category_id.required' => 'Sub Kategori produk wajib diisi',
            'description.required' => 'Deskripsi produk wajib diisi',
            'image.required' => 'Gambar produk wajib diisi',
            'image.array' => 'File yang diupload harus berupa gambar',
            'image.*.image' => 'File yang diupload harus berupa gambar',
            'image.*.mimes' => 'Format gambar yang diupload harus jpeg, png, jpg, gif, svg',
            'image.*.max' => 'Ukuran gambar tidak boleh melebihi 2MB',
            'stock.required' => 'Stok produk wajib diisi',
        ]);

        if($validate && $updateMode == false){
            $data = new Product();
            $data->name = $this->name;
            $data->slug = Str::slug($this->name);
            $data->price = $this->price;
            $data->category_id = $this->category_id;
            $data->sub_category_id = $this->sub_category_id;

            $data->description = $this->description;
             // Array untuk menyimpan nama-nama file gambar
            $imageNames = [];

            // Proses upload setiap gambar
            if ($this->image) {
                foreach ($this->image as $image) {
                    $imageName = auth()->user()->store->name . '-' . time() . '-' . uniqid() . '.' . $image->extension();
                    $destinationPath = public_path('storage/product/');
                    $img = Image::make($image->getRealPath());
                    $img->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath . '/' . $imageName);
                    $imageNames[] = $imageName;
                }
            }

            // Menyimpan nama-nama file gambar sebagai JSON
            $data->image = json_encode($imageNames);

            $data->stock = $this->stock;
            $data->status = '1';
            $data->store_id = auth()->user()->store_id;
            // $data->google_id = $this->google_id;
            $data->save();
            $this->resetInput();
            $this->alert('success', $this->name.' berhasil ditambahkan');
            $this->dispatch('closeModal');

            // log activity
            $log = new LogStore();
            $log->store_id = auth()->user()->store_id;
            $log->user_id = auth()->user()->id;
            $log->product_id = $data->id;
            $log->activity = 'Menambahkan produk '.$data->name;
            $log->description = 'Menambahkan produk '.$data->name.' dengan harga Rp.'.number_format($data->price, 0, ',', '.'). ' dan stok '.$data->stock;
            $log->save();
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = Product::where('id', $id)->first();
        $this->dataId = $data->id;
        $this->name = $data->name;
        $this->price = $data->price;
        $this->category_id = $data->category_id;
        $this->sub_category_id = $data->sub_category_id;
        $this->description = $data->description;
        $this->stock = $data->stock;
        $this->status = $data->status;
        $this->store_id = $data->store_id;
        $this->google_id = $data->google_id;

        $this->prevImage = json_decode($data->image);
    }

    public function update()
    {
        $validate = $this->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'description' => 'required',
            'stock' => 'required',
        ],[
            'name.required' => 'Nama produk wajib diisi',
            'price.required' => 'Harga produk wajib diisi',
            'category_id.required' => 'Kategori produk wajib diisi',
            'sub_category_id.required' => 'Sub Kategori produk wajib diisi',
            'description.required' => 'Deskripsi produk wajib diisi',
            'stock.required' => 'Stok produk wajib diisi',
        ]);

        if ($validate && $this->updateMode == true) {
            $data = Product::find($this->dataId);
            $data->name = $this->name;
            $data->slug = Str::slug($this->name);
            $data->price = $this->price;
            $this->category_id = $data->category_id;
            $this->sub_category_id = $data->sub_category_id;
            $data->description = $this->description;
            $data->stock = $this->stock;
            $data->status = '1';
            $data->store_id = auth()->user()->store_id;

            // Proses penghapusan gambar dan penambahan gambar baru
            if ($this->image) {
                // Hapus gambar yang sebelumnya
                foreach ($this->prevImage as $prevImage) {
                    $path = public_path('storage/product/' . $prevImage);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    $this->prevImage = array_values($this->prevImage);
                }

                // Upload gambar baru
                $imageNames = [];
                foreach ($this->image as $image) {
                    $imageName = auth()->user()->store->name . '-' . time() . '-' . uniqid() . '.' . $image->extension();
                    $destinationPath = public_path('storage/product/');
                    Image::make($image->getRealPath())
                        ->resize(500, 500, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath . '/' . $imageName);
                    $imageNames[] = $imageName;
                }

                // Gabungkan gambar baru dengan gambar sebelumnya
                $data->image = json_encode(array_merge($imageNames, $this->prevImage));
            }

            $data->save();
            $this->resetInput();
            $this->alert('success', $this->name.' berhasil diupdate');
            $this->dispatch('closeModal');

            // log activity
            $log = new LogStore();
            $log->store_id = auth()->user()->store_id;
            $log->user_id = auth()->user()->id;
            $log->product_id = $data->id;
            $log->activity = 'Mengupdate produk '.$data->name;
            $log->description = 'Mengupdate produk '.$data->name.' dengan harga Rp.'.number_format($data->price, 0, ',', '.'). ' dan stok '.$data->stock;
            $log->save();
        }
    }

    public function removeImage($index)
    {
        unset($this->image[$index]);
        $this->image = array_values($this->image); // Reindex array
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

         $this->data = Product::find($id);
    }

    public function onConfirmedAction()
    {
        $data = Product::find($this->data['id']);
        $images = json_decode($data->image);
        foreach ($images as $image) {
            $path = public_path('storage/product/' . $image);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $data->delete();
        $this->alert('success', $this->data['name'].' berhasil dihapus');

        // log activity
        // $log = new LogStore();
        // $log->store_id = auth()->user()->store_id;
        // $log->user_id = auth()->user()->id;
        // $log->activity = 'Menghapus produk '.$this->data['name'];
        // $log->description = 'Menghapus produk '.$this->data['name'].' dengan harga Rp.'.number_format($this->data['price'], 0, ',', '.'). ' dan stok '.$this->data['stock'];
        // $log->save();
    }

}
