<?php

namespace App\Livewire\Admin\Feedback;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Utility\Feedback;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert, WithPagination;

    public $data, $search, $dataMessage, $pesan;

    public function getListeners()
    {
        return [
            'changeStatusConfirmed' => 'changeStatusConfirmed',
        ];
    }

    public function render()
    {
        $datas = Feedback::when($this->search, function($query){
            return $query->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orWhere('telephone', 'like', '%'.$this->search.'%')
            ->orWhere('address', 'like', '%'.$this->search.'%')
            ->orWhere('messages', 'like', '%'.$this->search.'%');
        })->latest()->paginate(10);
        return view('livewire.admin.feedback.index',[
            'datas' => $datas
        ])->layout('components.admin_layouts.app')->layoutData([
            'title' => 'Kritik & Saran',
        ]);
    }

    public function changeStatus($id)
    {
        $this->data = Feedback::findOrfail($id);
        $this->confirm('Apakah Anda yakin ingin menampilkan Kritik & Saran ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Batal',
            'onConfirmed' => 'changeStatusConfirmed',
        ]);
    }

    public function changeStatusConfirmed()
    {
       if($this->data->status == 'Draft'){
           $this->data->status = 'Publish';
         }else{
              $this->data->status = 'Draft';
        }
        $this->data->save();
        $this->alert('success', 'Status Kritik dan Saran berhasil diubah');
    }

    public function modalMessage($id)
    {
        $this->dataMessage = Feedback::findOrfail($id);
        $this->pesan = $this->dataMessage->messages;
    }
}
