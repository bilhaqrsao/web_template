<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\LogActivity\LogUser;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function mount()
    {
        LogUser::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Logout',
            'description' => 'User logout '.auth()->user()->username,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        Auth::logout();
        return redirect()->route('public.login');
    }
}
