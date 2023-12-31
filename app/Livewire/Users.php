<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $id = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'User';
    public $status = 'Active';

    public $title = 'Add User';
    public $sbmBtn = 'Add User';

    public $sortField = 'id';
    public $sortDirection = 'asc';

    public function save()
    {
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:2',
            'role' => 'required',
            'status' => 'required',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'password_not_hashed' => $this->password,
            'status' => $this->status,
        ]);

        $role = Role::where('name', $this->role)->first();
        if ($role) {
            $user->assignRole($role);
        }

        session()->flash('success', "User {$this->name} has been added!");

        $this->name = $this->email = $this->password = null;
        $this->role = 'User';
        $this->status = 'Active';
    }

    public function edit($userId)
    {
        $user = User::find($userId);

        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $user->password_not_hashed;
        $this->role = $user->roles->first()->name;
        $this->status = $user->status;

        $this->title = 'Edit User';
        $this->sbmBtn = 'Update User';
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'password' => 'required|min:2',
            'role' => 'required',
            'status' => 'required',
        ]);

        $user = User::find($this->id);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'password_not_hashed' => $this->password,
            'status' => $this->status,
        ]);

        $role = Role::where('name', $this->role)->first();
        if ($role) {
            $user->syncRoles($role);
        }

        session()->flash('success', "User {$this->name} has been updated!");

        $this->id = $this->name = $this->email = $this->password = null;
        $this->role = 'User';
        $this->status = 'Active';
        $this->title = 'Add User';
    }

    public function delete($userId)
    {
        User::find($userId)->delete();

        session()->flash('success', "User has been deleted!");
    }

    public function sortBy($field, $direction)
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
    }

    public function render()
    {
        $users = User::when($this->sortField === 'role', function ($query) {
            return $query->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->orderBy('roles.name', $this->sortDirection)
                ->select('users.*', 'roles.name as role_name') // Include the role name column
                ->distinct();
        }, function ($query) {
            return $query->orderBy($this->sortField, $this->sortDirection);
        })->paginate(10);

        foreach ($users as $user) {
            $user->role = $user->roles->first()->name;
        }

        return view('livewire.users', compact('users'));
    }
}
