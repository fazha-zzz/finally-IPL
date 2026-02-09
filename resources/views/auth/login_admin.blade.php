@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="logo">
        <img src="{{ asset('assets/images/big/HOM.png') }}" alt="Logo">
    </div>
    <h1 class="residence-name">HOM</h1>
    <h2 class="login-type">Login Admin</h2>

    <form class="login-form" method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="input-group">
            <input id="username" type="text" class="@error('username') is-invalid @enderror"
                   name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group">
            <input id="password" type="password" class="@error('password') is-invalid @enderror"
                   name="password" placeholder="Password" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="remember-me">
            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">Remember Me</label>
        </div>

        <button type="submit" class="submit-btn">
            Login Admin
        </button>

        <div class="switch-login">
            <p>Login sebagai <a href="{{ route('login') }}">User</a></p>
        </div>
    </form>
</div>

<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background: linear-gradient(to bottom, #a8dadc, #f1faee);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        color: #333;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        box-sizing: border-box;
    }

    .logo img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #f1faee;
        border: 3px solid #457b9d;
        padding: 10px;
    }

    .residence-name {
        font-size: 24px;
        font-weight: 600;
        color: #457b9d;
        margin: 20px 0 10px 0;
    }

    .login-type {
        font-size: 18px;
        font-weight: 500;
        color: #457b9d;
        margin: 0 0 25px 0;
        background: rgba(69, 123, 157, 0.08);
        padding: 8px 16px;
        border-radius: 20px;
        display: inline-block;
    }

    .input-group {
        margin-bottom: 20px;
        position: relative;
    }

    .input-group input {
        width: 100%;
        padding: 15px 20px;
        border: none;
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.5);
        font-size: 16px;
        color: #457b9d;
        transition: background-color 0.3s;
        box-sizing: border-box;
    }

    .input-group input:focus {
        outline: none;
        background-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 0 3px rgba(69, 123, 157, 0.3);
    }

    .input-group input::placeholder {
        color: rgba(69, 123, 157, 0.7);
    }

    .input-group .is-invalid {
        border: 2px solid #e74c3c;
    }

    .invalid-feedback {
        color: #e74c3c;
        font-size: 12px;
        position: absolute;
        bottom: -18px;
        left: 0;
    }

    .remember-me {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        color: #555;
    }

    .remember-me input[type="checkbox"] {
        margin-right: 8px;
        transform: scale(1.2);
    }

    .remember-me label {
        font-size: 14px;
        cursor: pointer;
    }

    .submit-btn {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 600;
        color: white;
        background: linear-gradient(to right, #6aa84f, #38761d);
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .submit-btn:hover {
        background: linear-gradient(to right, #4a8035, #295214);
        transform: translateY(-2px);
    }

    .switch-login {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .switch-login p {
        margin: 0;
        font-size: 14px;
        color: #457b9d;
    }

    .switch-login a {
        color: #457b9d;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 1px solid transparent;
        transition: border-bottom 0.3s;
    }

    .switch-login a:hover {
        border-bottom: 1px solid #457b9d;
    }
</style>
@endsection
