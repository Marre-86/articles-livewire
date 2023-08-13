<div>
    <div class="w-30" style="float:left">
        <div class="card">
            <div class="card-header">
                <h3>{{ $title }}</h3>
            </div>
            <div class="card-body">
            <form id="add-user-form"
                @if($title === 'Add User') 
                    wire:submit="save"
                @elseif($title === 'Edit User') 
                    wire:submit="update"
                @endif>
                
                @if(session()->has('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" class="alert alert-dismissible alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model="name" class="form-control-plaintext">
                            <div>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model="email" class="form-control-plaintext">
                            <div>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model="password" class="form-control-plaintext">
                            <div>
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="password" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="roleUser" wire:model="role" value="User" checked="">
                                <label class="form-check-label" for="roleUser">User</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="roleAdmin" wire:model="role" value="Admin">
                                <label class="form-check-label" for="roleAdmin">Admin</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="password" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusActive" wire:model="status" value="Active" checked="">
                                <label class="form-check-label" for="statusActive">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusInactive" wire:model="status" value="Inactive">
                                <label class="form-check-label" for="statusInactive">Inactive</label>
                            </div>
                        </div>
                    </div>

                    <div class="user-sbm">
                        <button type="submit" class="btn btn-primary">{{ $sbmBtn }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="w-60 users-index">
      <div class="card" style="margin-bottom:1rem; min-width:fit-content;">
        <div class="card-header">

                <h3>List of Users</h3>

        </div>
        <div style="padding: 1rem 0.5rem 0 0.5rem">
          <table class="table table-hover">
            <thead>
                <tr class="text-center" >
                    <th style="width:13%" scope="col">Id
                        <button
                            @if ($sortField === 'id' && $sortDirection === 'asc')
                                wire:click="sortBy('id', 'desc')"
                            @else
                                wire:click="sortBy('id', 'asc')"
                            @endif
                            class="btn btn-outline-primary sort-btn-sm {{ $sortField === 'id' ? 'active' : '' }}">
                            @if($sortField === 'id' && $sortDirection === 'asc')
                                <img src="/pics/sort-up.svg" alt="sort-by-id">
                            @else
                                <img src="/pics/sort-down.svg" alt="sort-by-id">
                            @endif
                        </button>
                    </th>
                    <th scope="col" style="width:20%">Name
                        <button
                            @if ($sortField === 'name' && $sortDirection === 'asc')
                                wire:click="sortBy('name', 'desc')"
                            @else
                                wire:click="sortBy('name', 'asc')"
                            @endif
                            class="btn btn-outline-primary sort-btn-sm {{ $sortField === 'name' ? 'active' : '' }}">
                            @if($sortField === 'name' && $sortDirection === 'asc')
                                <img src="/pics/sort-up.svg" alt="sort-by-name">
                            @else
                                <img src="/pics/sort-down.svg" alt="sort-by-name">
                            @endif
                        </button>
                    </th>
                    <th scope="col" style="width:14%">Email
                        <button
                            @if ($sortField === 'email' && $sortDirection === 'asc')
                                wire:click="sortBy('email', 'desc')"
                            @else
                                wire:click="sortBy('email', 'asc')"
                            @endif
                            class="btn btn-outline-primary sort-btn-sm {{ $sortField === 'email' ? 'active' : '' }}">
                            @if($sortField === 'email' && $sortDirection === 'asc')
                                <img src="/pics/sort-up.svg" alt="sort-by-email">
                            @else
                                <img src="/pics/sort-down.svg" alt="sort-by-email">
                            @endif
                        </button>
                    </th>
                    <th scope="col" style="width:15%">Password</th>
                    <th scope="col" style="width:15%">Role
                        <button
                            @if ($sortField === 'role' && $sortDirection === 'asc')
                                wire:click="sortBy('role', 'desc')"
                            @else
                                wire:click="sortBy('role', 'asc')"
                            @endif
                            class="btn btn-outline-primary sort-btn-sm {{ $sortField === 'role' ? 'active' : '' }}">
                            @if($sortField === 'role' && $sortDirection === 'asc')
                                <img src="/pics/sort-up.svg" alt="sort-by-role">
                            @else
                                <img src="/pics/sort-down.svg" alt="sort-by-role">
                            @endif
                        </button>
                    </th>
                    <th scope="col" style="width:15%">Status
                        <button
                            @if ($sortField === 'status' && $sortDirection === 'asc')
                                wire:click="sortBy('status', 'desc')"
                            @else
                                wire:click="sortBy('status', 'asc')"
                            @endif
                            class="btn btn-outline-primary sort-btn-sm {{ $sortField === 'status' ? 'active' : '' }}">
                            @if($sortField === 'status' && $sortDirection === 'asc')
                                <img src="/pics/sort-up.svg" alt="sort-by-status">
                            @else
                                <img src="/pics/sort-down.svg" alt="sort-by-status">
                            @endif
                        </button>
                    </th>
                    <th scope="col" style="width:20%">Created At
                        <button
                            @if ($sortField === 'created_at' && $sortDirection === 'asc')
                                wire:click="sortBy('created_at', 'desc')"
                            @else
                                wire:click="sortBy('created_at', 'asc')"
                            @endif
                            class="btn btn-outline-primary sort-btn-sm {{ $sortField === 'created_at' ? 'active' : '' }}">
                            @if($sortField === 'created_at' && $sortDirection === 'asc')
                                <img src="/pics/sort-up.svg" alt="sort-by-created_at">
                            @else
                                <img src="/pics/sort-down.svg" alt="sort-by-created_at">
                            @endif
                        </button>
                    </th>
                    <th scope="col" style="width:20%">Updated At
                        <button
                            @if ($sortField === 'updated_at' && $sortDirection === 'asc')
                                wire:click="sortBy('updated_at', 'desc')"
                            @else
                                wire:click="sortBy('updated_at', 'asc')"
                            @endif
                            class="btn btn-outline-primary sort-btn-sm {{ $sortField === 'updated_at' ? 'active' : '' }}">
                            @if($sortField === 'updated_at' && $sortDirection === 'asc')
                                <img src="/pics/sort-up.svg" alt="sort-by-updated_at">
                            @else
                                <img src="/pics/sort-down.svg" alt="sort-by-updated_at">
                            @endif
                        </button>
                    </th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 0; @endphp
                @foreach ($users as $user)
                    @php $class = $counter % 2 === 0 ? 'table-active' : 'table-default'; @endphp
                    <tr class="{{ $class }} text-center">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->password_not_hashed }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->status }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>
                          <div class="button-group d-flex">
                            <a wire:click="edit({{ $user->id }})" class="btn btn-outline-success btn-sm" href="#">edit</a>
                          </div>
                        </td>
                        <td>
                          @unless (auth()->id() === $user->id)
                            <div class="button-group d-flex">
                                <a wire:confirm="Are you sure?" wire:click="delete({{ $user->id }})" class="btn btn-danger btn-sm" href="#">X</a>
                            </div>
                          @endunless
                        </td>
                    </tr>
                    @php $counter++; @endphp
                @endforeach
            </tbody>
          </table>
          {{ $users->links() }}
        </div>
      </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.directive('confirm', ({ el, directive, component, cleanup }) => {
            let content =  directive.expression        
       
            let onClick = e => {
                if (! confirm(content)) {
                    e.preventDefault()
                    e.stopPropagation()
                }
            }
        
            el.addEventListener('click', onClick, { capture: true })
        
            cleanup(() => {
                el.removeEventListener('click', onClick)
            })
        })
    })
 
    document.addEventListener('livewire:initialized', () => {
        // Runs immediately after Livewire has finished initializing
        // on the page...
    })
</script>
