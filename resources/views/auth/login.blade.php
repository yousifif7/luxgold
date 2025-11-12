@extends('layouts.auth')
@section('title','Login - AskRoro')
@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height:100vh;padding:24px;">
  <div class="login-card-longkeywordclass">
    <div class="d-flex justify-content-center mb-3">
        <img src="{{ asset('provider/assets/updated-logo.jpeg') }}" alt="AskRoro">
    </div>
    <h1 class="login-title-longkeywordclass">Login to AskRoro</h1>
    <form method="POST" action="{{ route('login') }}">
      @csrf

      {{-- session / global errors/status --}}
      @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="mb-3">
        <label class="login-form-label-longkeywordclass" for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control login-form-control-longkeywordclass @error('email') is-invalid @enderror" placeholder="Enter your email" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="mb-1">
        <label class="login-form-label-longkeywordclass" for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control login-form-control-longkeywordclass @error('password') is-invalid @enderror" placeholder="Enter your password" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="login-forgot-password-longkeywordclass">Forgot password?</a>
      @endif

      <button type="submit" class="login-btn-longkeywordclass">Continue</button>
    </form>
    <div class="login-bottom-text-longkeywordclass">
      Don’t have an account? <a href="{{ route('register') }}">Create Account</a>
    </div>
  </div>
</div>
@endsection
