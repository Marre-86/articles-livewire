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
                                <input class="form-check-input" type="radio" name="role" wire:model="role" value="User" checked="">
                                <label class="form-check-label" for="optionsRadios1">User</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" wire:model="role" value="Admin">
                                <label class="form-check-label" for="optionsRadios2">Admin</label>
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
                    <th scope="col">Id</th>
                    <th scope="col" style="width:50%">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
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
