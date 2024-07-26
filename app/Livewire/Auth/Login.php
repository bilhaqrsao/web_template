<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\LogActivity\LogUser;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Login extends Component
{
    use LivewireAlert;
    public $username, $password;

    public function render()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('livewire.auth.login')->layout('components.admin_layouts.login');
    }

    public function rememberMe()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('public.login');
        }
    }

    public function loginAttempt()
    {
        // check jika sudah pernah login maka langsung dilogout
        if (auth()->check()) {
            Auth::logout();
        }else{
            if (session('login_attempt') >= 5) {
                sleep(2);
                session()->forget('login_attempt');
                $this->alert('error', 'Spam');
            }

            $validate = $this->validate([
                'username' => 'required',
                'password' => 'required',
            ],[
                'username.required' => 'Username tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
            ]);

            // check role jika login dengan role berbeda redirect ke halaman yang sesuai
            if ($validate) {
                if (auth()->attempt([
                    'username' => $this->username,
                    'password' => $this->password,
                ])) {
                    LogUser::create([
                        'user_id' => auth()->user()->id,
                        'activity' => 'Login',
                        'description' => 'User login '.auth()->user()->username,
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);
                    // redirect to admin.dashboard
                    $this->flash('success', 'Login Berhasil', [], route('admin.dashboard'));
                } else {
                    $this->alert('error', 'Username atau Password Salah');
                    session()->put('login_attempt', session('login_attempt', 0) + 1);
                }
            }
        }
    }


}
