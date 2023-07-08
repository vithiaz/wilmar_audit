<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginPage extends Component
{
    // Binding Variable
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount() {
        $this->email = '';
        $this->password = '';
    }

    public function render()
    {
        return view('livewire.login-page')->layout('layouts.login');
    }

    public function login() {
        $this->validate();
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], true)) {
            return redirect()->route('audit');
        }
        else {
            $this->password = '';
            session()->flash('error', 'Email atau password salah!');
        }

    }
}
