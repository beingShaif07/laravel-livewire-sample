<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class ListUsers extends Component
{
    public $data = [];

    public function addNew()
    {
        $this->dispatchBrowserEvent('show-modal');
    }

    public function createUser()
    {
        $validated_data = Validator::make($this->data, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ])->validate();

        User::create($validated_data);

        $this->dispatchBrowserEvent('hide-modal');

        return redirect()->back();
    }

    public function render()
    {
        $users = User::latest()->paginate();

        return view('livewire.admin.users.list-users', ['users' => $users]);
    }
}
