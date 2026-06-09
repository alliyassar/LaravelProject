@extends('welcome')

@section('title') Register - NovaStore @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-5">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h4 class="mb-0 fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Create Account</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="john@example.com" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark fw-bold py-2">Register</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center bg-light py-3">
                    <span class="small text-muted">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Sign In</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection