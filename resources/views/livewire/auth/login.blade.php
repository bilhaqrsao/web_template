<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="d-flex justify-content-center">

        <!-- Form starts -->
        <form wire:submit.prevent="loginAttempt">

            <!-- Logo starts -->
            <a href="{{ route('public.login') }}" class="auth-logo mt-5 mb-3">
                <img src="{{ asset('images/logo-bilhaq.png') }}" alt="" />
            </a>
            <!-- Logo ends -->

            <!-- Authbox starts -->
            <div class="auth-box">

                <h4 class="mb-4">Welcome back,</h4>

                <div class="mb-3">
                    <label class="form-label" for="email">Username <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="text" wire:model="username" class="form-control @error('username') is-invalid @enderror" placeholder="Masukan Username">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukan Password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        {{-- <button wire:ignore class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-eye"></i>
                        </button> --}}
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <a href="javascript:;" class="text-decoration-underline">Forgot password?</a>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="javascript:;" class="btn btn-outline-secondary">Not registered? Signup</a>
                </div>

            </div>
            <!-- Authbox ends -->

        </form>
        <!-- Form ends -->

    </div>
</div>
