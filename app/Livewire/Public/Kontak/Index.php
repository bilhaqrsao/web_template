<?php

namespace App\Livewire\Public\Kontak;

use App\Models\Utility\Feedback;
use App\Models\Utility\IdentityWeb;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Index extends Component
{
    use LivewireAlert;
    public $name, $email, $telephone, $messages, $address;

    public function render()
    {
        $identitas = IdentityWeb::first();
        return view('livewire.public.kontak.index',[
            'identitas' => $identitas
        ])->layoutData(['title' => 'Kontak Kami']);
    }

    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->telephone = '';
        $this->address = '';
        $this->messages = '';
    }

    public function store()
    {
       try {
        $validate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'telephone' => 'required|numeric|min:11',
            'address' => 'required',
            'messages' => 'required|min:10'
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'telephone.required' => 'Nomor telepon tidak boleh kosong',
            'telephone.numeric' => 'Nomor telepon harus angka',
            'telephone.min' => 'Nomor telepon minimal 11 digit',
            'address.required' => 'Alamat tidak boleh kosong',
            'messages.required' => 'Pesan tidak boleh kosong',
            'messages.min' => 'Pesan minimal 10 karakter'
        ]);

        if($validate){
            $data = new Feedback();
            $data->name = $this->name;
            $data->email = $this->email;
            $data->telephone = $this->telephone;
            $data->address = $this->address;
            $data->messages = $this->messages;
            $data->save();
            $this->resetInput();
           $this->alert('success','Pesan berhasil dikirim');
        }
       } catch (\Exception $e) {
        //    get error validation
        $this->alert('error',$e->getMessage());
       }
    }
}
