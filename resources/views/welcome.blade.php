@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="logo">
        <!-- Ganti URL ini dengan path ke logo Anda -->
        <img src="{{ asset('assets/images/big/pesona1.jpg') }}" alt="Logo">
    </div>
    <h1 class="residence-name">HOM</h1>

    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group">
            <input id="no_rumah" type="text" class="@error('no_rumah') is-invalid @enderror" name="no_rumah" value="{{ old('no_rumah') }}" placeholder="No. Rumah" required autofocus>
            @error('no_rumah')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group">
            <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" placeholder="Password" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <div class="contact-admin-link">
            <i class="fas fa-question-circle"></i> Belum terdaftar? <a href="https://wa.me/628815873744?text=Halo%20Admin,%20saya%20belum%20terdaftar" 
       target="_blank" 
       >
         Hubungi Admin
    </a>
        </div>
        
        
        <button type="submit" class="submit-btn">
            Submit
        </button>
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
        margin: 20px 0;
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

    .contact-admin-link {
        font-size: 14px;
        margin-bottom: 25px;
        color: #457b9d;
    }
    
    .contact-admin-link a {
        color: #457b9d;
        text-decoration: none;
        font-weight: 500;
        border-bottom: 1px solid transparent;
        transition: border-bottom 0.3s;
    }
    
    .contact-admin-link a:hover {
        border-bottom: 1px solid #457b9d;
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
</style>
@endsection