<?php

namespace App\Livewire\Admin\Berkas;

use Livewire\Component;
use App\Traits\HelpersCdn;
use App\Models\Core\Berkas;
use App\Models\LogActivity\LogUser;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithFileUploads, WithPagination, LivewireAlert, HelpersCdn;

    public $search, $title, $file, $created_at, $data,$identitas, $statusData = 'Draft', $status;
    public $limit = 10;

    public $url = 'https://cdn.oganilirkab.go.id/storage/';

    public function getListeners()
    {
        return [
            'changeStatus' => 'changeStatus',
            'deleteData' => 'deleteData',
        ];
    }

    public function render()
    {
        $datas = Berkas::orderBy('created_at', 'DESC')
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->paginate($this->limit);

        return view('livewire.admin.berkas.index', [
            'datas' => $datas,
        ])->layout('components.admin_layouts.app')->layoutData(['title' => 'File Berkas']);
    }

    public function resetInput()
    {
        $this->title = '';
        $this->file = null;
        $this->created_at = null;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|unique:berkas,title',
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',
        ], [
            'title.required' => 'Judul tidak boleh kosong',
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'File harus berupa pdf, doc, docx, xls, xlsx, ppt, pptx, zip, rar, jpg, jpeg, png',
        ]);

        try {
            $data = new Berkas();
            $data->title = $this->title;
            $data->slug = Str::slug($this->title);

            if ($this->file) {
                $random = Str::slug($this->title);
                $filename = $random . '.' . $this->file->getClientOriginalExtension();

                $params = [
                    'path' => 'Website',
                    'sub_path' => 'Berkas'
                ];

                $response = $this->handleUploadFilesCdn($this->file, $filename, $params);
                if ($response->getStatusCode() == 200) {
                    $data->file = $params['path'] . '/' . $params['sub_path'] . '/' . $filename;
                } else {
                    $data->file = null;
                    $this->showToastr('error', 'Gagal', 'File gagal diupload');
                }

            }

            $data->created_at = $this->created_at;
            $data->status = $this->statusData;

            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Create',
                'description' => 'Menambahkan file berkas ' . $this->title
            ]);
            $data->save();

            $this->alert('success', 'Data berhasil disimpan');
            $this->dispatch('closeModal');
            $this->resetInput();


        } catch (\Exception $e) {
            Log::error('Store error: '.$e->getMessage() . ' Line: ' . $e->getLine());
            $this->alert('error', $e->getMessage() .  $e->getLine());
        }
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

        $this->data = Berkas::findOrFail($id);
    }

    public function deleteData()
    {
        // delete data file from cdn
        $file_path = $this->data->file;
        $file_name = basename($file_path);

        $params = [
            'file' => $file_name,
            'path' => 'Website',
            'sub_path' => 'Berkas',
        ];

        $response = $this->handleDeleteFileCdn($file_name, $params);
        if ($response->getStatusCode() == 200) {
            LogUser::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Delete',
                'description' => 'Menghapus file berkas ' . $this->data->title
            ]);
            $this->data->delete();
            $this->alert('success', 'Data berhasil dihapus');
        } else {
            $this->alert('error', 'Gagal menghapus file');
        }
    }

    public function ubahStatus($id)
    {
        $this->confirm('Yakin ingin mengubah status data ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'changeStatus',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = Berkas::findOrFail($id);
    }

    public function changeStatus()
    {
        try {
            $this->data->status = $this->data->status == 'Draft' ? 'Publish' : 'Draft';
            $this->data->save();
            $this->alert('success', 'Status berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Change status error: '.$e->getMessage());
            $this->alert('error', $e->getMessage());
        }
    }
}
