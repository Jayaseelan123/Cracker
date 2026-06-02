@extends('layouts.admin')

@section('title', 'Admin Profile Settings')
@section('header', 'Profile Settings')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="fas fa-user-edit me-2"></i> Update Profile Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf

                        <!-- Profile Info Section -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold text-muted small">Name</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold text-muted small">Phone Number</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <!-- Password Security Section -->
                        <h6 class="text-secondary fw-bold mb-3">
                            <i class="fas fa-key me-2"></i> Change Password
                        </h6>
                        <p class="text-muted small mb-4">If you want to change your password, please fill in your current password first. Otherwise, leave these fields blank.</p>

                        <div class="row">
                            <!-- Current Password -->
                            <div class="col-md-12 mb-3">
                                <label for="old_password" class="form-label fw-semibold text-muted small">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg bg-light border-0" id="old_password" name="old_password" placeholder="Enter current password to make changes">
                                    <button class="btn btn-light border-0" type="button" onclick="togglePassword('old_password', 'eye-old')">
                                        <i id="eye-old" class="fas fa-eye text-muted"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-semibold text-muted small">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg bg-light border-0" id="password" name="password" placeholder="Minimum 8 characters" disabled required>
                                    <button class="btn btn-light border-0" type="button" onclick="togglePassword('password', 'eye-new')" id="btn-eye-new" disabled>
                                        <i id="eye-new" class="fas fa-eye text-muted"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold text-muted small">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg bg-light border-0" id="password_confirmation" name="password_confirmation" placeholder="Repeat new password" disabled required>
                                    <button class="btn btn-light border-0" type="button" onclick="togglePassword('password_confirmation', 'eye-confirm')" id="btn-eye-confirm" disabled>
                                        <i id="eye-confirm" class="fas fa-eye text-muted"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Form Submission -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm fw-bold">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Client-side UX flow: Enable new password fields only when old password has value
    document.addEventListener('DOMContentLoaded', function() {
        const oldPass = document.getElementById('old_password');
        const newPass = document.getElementById('password');
        const confirmPass = document.getElementById('password_confirmation');
        
        const btnEyeNew = document.getElementById('btn-eye-new');
        const btnEyeConfirm = document.getElementById('btn-eye-confirm');

        function handlePasswordFields() {
            if (oldPass.value.trim().length > 0) {
                newPass.removeAttribute('disabled');
                confirmPass.removeAttribute('disabled');
                btnEyeNew.removeAttribute('disabled');
                btnEyeConfirm.removeAttribute('disabled');
            } else {
                newPass.setAttribute('disabled', 'disabled');
                confirmPass.setAttribute('disabled', 'disabled');
                btnEyeNew.setAttribute('disabled', 'disabled');
                btnEyeConfirm.setAttribute('disabled', 'disabled');
                
                // Clear fields if they were disabled
                newPass.value = '';
                confirmPass.value = '';
            }
        }

        oldPass.addEventListener('input', handlePasswordFields);
    });
</script>
@endsection
