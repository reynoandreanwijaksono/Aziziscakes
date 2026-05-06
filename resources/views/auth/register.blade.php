<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar – Aziziscake</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Poppins',sans-serif; background:#f6f1eb; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
.auth-container { width:100%; max-width:460px; }
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
.form-row { display:flex; gap:14px; }
.form-row .form-group { flex:1; }
.btn-auth { width:100%; background:#7a4b2b; color:white; padding:14px; border:none; border-radius:25px; font-family:'Poppins',sans-serif; font-size:15px; font-weight:500; cursor:pointer; transition:0.3s; margin-top:8px; }
.btn-auth:hover { background:#5a3825; transform:translateY(-1px); }
.auth-footer { text-align:center; margin-top:22px; font-size:13px; color:#888; }
.auth-footer a { color:#7a4b2b; text-decoration:none; font-weight:500; }
.terms { font-size:12px; color:#aaa; text-align:center; margin-top:12px; }
.terms a { color:#7a4b2b; }
</style>
</head>
<body>
<div class="auth-container">
    <div class="auth-logo">
        <span>🎂 Aziziscake</span>
        <p>Toko Roti & Kue Premium Jepara</p>
    </div>

    <div class="auth-card">
        <h2>Buat Akun</h2>
        <p class="sub">Bergabung dan nikmati kemudahan belanja</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required autofocus>
                @error('name') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                @error('email') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Nomor Telepon / WhatsApp</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xx xxxx xxxx">
                @error('phone') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Min. 8 karakter" required>
                    @error('password') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn-auth">Daftar Sekarang 🎉</button>
            <p class="terms">Dengan mendaftar, Anda menyetujui <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a> kami.</p>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>
</div>
</body>
</html>
