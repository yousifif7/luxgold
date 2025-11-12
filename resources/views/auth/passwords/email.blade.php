@extends('layouts.auth')
@section('title','Forgot Password - AskRoro')
@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height:100vh;padding:24px;">
  <div class="login-card-longkeywordclass">
    <div class="d-flex justify-content-center mb-3">
        <img src="{{ asset('provider/assets/updated-logo.jpeg') }}" alt="AskRoro">
    </div>
    <h1 class="login-title-longkeywordclass">Forgot Password</h1>
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
    <form method="POST" action="{{ route('password.email') }}">
      @csrf



      <div class="mb-3">
        <label class="login-form-label-longkeywordclass" for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control login-form-control-longkeywordclass @error('email') is-invalid @enderror" placeholder="Enter your email" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      


      <button type="submit" class="login-btn-longkeywordclass"> {{ __('Send Password Reset Link') }}</button>
    </form>
    
  </div>
</div>
@endsection
