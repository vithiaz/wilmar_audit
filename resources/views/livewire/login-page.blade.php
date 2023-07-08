@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/login-page.css') }}">
@endpush


<div class="login-page">
    <div class="container">
        <section class="login">
            <form wire:submit.prevent='login' class="login-card-container">
                <div class="login-card-header">
                    <h1>LOGIN</h1>
                </div>
                <div class="login-card-body">
                    <div class="form-floating mb-3">
                        <input wire:model='email' type="email" class="form-control @if(Session::has('error')) is-invalid @endif @error('email') is-invalid @enderror" id="emailInput" placeholder="email">
                        <label for="emailInput">Email</label>
                        @error('email')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input wire:model='password' type="password" class="form-control @if(Session::has('error')) is-invalid @endif @error('password') is-invalid @enderror" id="passwordInput" placeholder="password">
                        <label for="passwordInput">Password</label>
                        @error('password')
                            <small class="error">{{ $message }}</small>
                        @enderror
                        @if (Session::has('error'))
                            <small class="error">{{ Session::get('error') }}</small>
                        @endif
                    </div>
                    <div class="button-container">
                        <button type="submit" class="btn login-button">Login</button>
                    </div>
                </div>
            </form>
            
        </section>
    </div>
</div>
