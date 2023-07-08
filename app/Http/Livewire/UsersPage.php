<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UsersPage extends Component
{
    // Binding Variable
    public $name;
    public $user_type;
    public $email;
    public $password;
    public $confirm_password;


    protected $rules = [
        'name' => 'required|string',
        'user_type' => 'required',
        'email' => 'required|email',
        'password' => 'required|string|min:8',
        'confirm_password' => 'same:password',
    ];

    public function mount() {
        $this->name = '';
        $this->user_type = '';
        $this->email = '';
        $this->password = '';
        $this->confirm_password = '';
    }


    public function render()
    {
        return view('livewire.users-page')->layout('layouts.app');
    }

    public function store_user() {
        $this->validate();
        
        $newUser = new User;
        $newUser->name = $this->name;
        $newUser->user_type = $this->user_type;
        $newUser->email = $this->email;
        $newUser->password = Hash::make($this->confirm_password);

        if ($newUser->save()) {
            $msg = ['success' => 'User ditambahkan'];
        } else {
            $msg = ['danger' => 'Terjadi kesalahan'];
        }
        $this->dispatchBrowserEvent('display-message', $msg);
        $this->emitTo('users-table', 'refreshTable');

        $this->name = '';
        $this->user_type = '';
        $this->email = '';
        $this->password = '';
        $this->confirm_password = '';
    }


}
