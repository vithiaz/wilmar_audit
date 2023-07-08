@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/users-page.css') }}">
@endpush


<div class="page-content users-page">
    <div class="container">
        <div class="page-title">
            <h1>Tambahkan User</h1>
        </div>

        <form wire:submit.prevent='store_user' class="page-card">
            <div class="row-wrapper">
                <div class="row-item-wrapper form-wrapper">
                    <div class="form-input-wrapper row">
                        <span class="form-title">Tipe User</span>
                        <div class="form-items">
                            <select wire:model='user_type' id="input-category-select">
                                <option value="" selected hidden>Pilih tipe user</option>
                                <option value="admin">Admin</option>
                                <option value="auditor">Auditor</option>
                            </select>
                            @error('user_type')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Nama</span>
                        <div class="form-items">
                            <input wire:model='name' class="form-input-default" type="text" placeholder="Nama User">
                            @error('name')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Email</span>
                        <div class="form-items">
                            <input wire:model='email' class="form-input-default" type="email" placeholder="Email">
                            @error('email')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Password</span>
                        <div class="form-items">
                            <input wire:model='password' class="form-input-default" type="password" placeholder="Password">
                            @error('password')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input-wrapper row">
                        <span class="form-title">Konfirmasi Password</span>
                        <div class="form-items">
                            <input wire:model='confirm_password' class="form-input-default" type="password" placeholder="Konfirmasi Password">
                            @error('confirm_password')
                                <small class="error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row-item-wrapper">
                    <div class="button-wrapper">
                        <button class="btn submit-button">Tambahkan User</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="page-card">
            <h2 class="card-title">Daftar user</h2>
            <div class="table-container">
                <livewire:users-table />
            </div>
        </div>


    </div>
</div>
