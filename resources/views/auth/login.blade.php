<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login – Aziziscake</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Poppins',sans-serif; background:#f6f1eb; min-height:100vh; display:flex; align-items:center; justify-content:center; }
.auth-container { width:100%; max-width:440px; padding:20px; }
.auth-logo { text-align:center; margin-bottom:30px; }
.auth-logo span { font-family:'Playfair Display',serif; font-size:30px; color:#5a3825; }
.auth-logo p { color:#888; font-size:13px; margin-top:5px; }
.auth-card { background:white; border-radius:24px; padding:38px; box-shadow:0 10px 40px rgba(0,0,0,0.1); }
.auth-card h2 { font-family:'Playfair Display',serif; font-size:26px; color:#4b2e1e; margin-bottom:6px; }
.auth-card p.sub { color:#888; font-size:13px; margin-bottom:28px; }
.form-group { margin-bottom:16px; }
.form-group label { display:block; font-size:11px; letter-spacing:1.5px; color:#aaa; text-transform:uppercase; margin-bottom:7px; }
.form-group input { width:100%; padding:13px 16px; border:1.5px solid #e8e0d8; border-radius:12px; font-family:'Poppins',sans-serif; font-size:14px; background:#faf8f5; color:#333; outline:none; transition:border 0.3s; }
.form-group input:focus { border-color:#7a4b2b; background:white; }
.error-text { color:#dc3545; font-size:12px; margin-top:5px; }
.alert { background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:18px; }
.btn-auth { width:100%; background:#7a4b2b; color:white; padding:14px; border:none; border-radius:25px; font-family:'Poppins',sans-serif; font-size:15px; font-weight:500; cursor:pointer; transition:0.3s; margin-top:8px; }
.btn-auth:hover { background:#5a3825; transform:translateY(-1px); }
.auth-footer { text-align:center; margin-top:22px; font-size:13px; color:#888; }
.auth-footer a { color:#7a4b2b; text-decoration:none; font-weight:500; }
.remember-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
.remember-row label { font-size:13px; color:#666; display:flex; align-items:center; gap:6px; cursor:pointer; }
.remember-row a { font-size:13px; color:#7a4b2b; text-decoration:none; }
</style>
</head>
<body>
<div class="auth-container">
    <div class="auth-logo">
        <span>🎂 Aziziscake</span>
        <p>Toko Roti & Kue Premium Jepara</p>
    </div>

    <div class="auth-card">
        <h2>Selamat Datang!</h2>
        <p class="sub">Masuk ke akun Aziziscake Anda</p>

        @if($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
        @endif

        @if(session('status'))
        <div style="background:#d4edda; border:1px solid #c3e6cb; color:#155724; padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:18px;">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                @error('email') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
                @error('password') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn-auth">Masuk →</button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </div>
</div>
</body>
</html>
