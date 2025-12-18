<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Inventori Barang</title>
   <link rel="icon" type="image/png" href="{{ asset('boxes.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Match login page spacing and sizes */
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #005f99, #0077b3);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            padding: 1rem;
        }

        .login-container {
            background-color: #fff;
            border-radius: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            max-width: 460px;
            width: 92%;
            padding: 2rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .login-container:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.25); }

        .logo { display:block; margin:0 auto 1rem; width:80px; height:auto }
        h2 { font-size:1.75rem; font-weight:800; color:#004d80; margin-bottom:0.5rem }
        h3 { font-size:1.5rem; font-weight:750; color:#006699; margin-bottom:1.5rem }

        form { display:flex; flex-direction:column; gap:1rem; align-items:center }
        .form-grid { width:100%; display:grid; grid-template-columns: 1fr 1fr; gap:1rem; column-gap:1rem; justify-items:center }
        .form-group { width:100%; display:flex; flex-direction:column; align-items:flex-start; box-sizing:border-box }
        .form-group.full { grid-column: 1 / -1 }
        label { font-weight:600; color:#004d80; margin-bottom:0.25rem }

        input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
            width: 100%; padding:0.75rem 1rem; border-radius:0.75rem; border:2px solid #006699; transition:all 0.3s ease; box-sizing:border-box;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="file"]:focus { outline:none; border-color:#004d80; box-shadow:0 0 8px rgba(0,77,128,0.4) }

        .btn-login { background-color:#006699; color:#fff; font-weight:800; padding:0.75rem 1.5rem; border-radius:3rem; border:none; cursor:pointer; transition:all 0.3s ease; width:90%; align-self:center }
        .btn-login:hover { background-color:#004d80; transform:translateY(-2px); box-shadow:0 6px 18px rgba(0,0,0,0.25) }

        .btn-secondary { background:#34a853; color:#fff; font-weight:700; padding:0.6rem 1rem; border-radius:3rem; text-decoration:none; display:inline-block; width:90%; text-align:center }

        .input-error { color:#e02424; font-size:0.85rem; margin-top:0.25rem }

        @media (max-width:576px) { .login-container{padding:2rem 1.5rem} h2{font-size:1.5rem} h3{font-size:1rem} .btn-login{width:70%} }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="{{ asset('pemprov.png') }}" alt="Logo" class="logo">
        <h2>DISPERMADESDUKCAPIL PROVINSI JATENG</h2>
        <h3>REGISTRASI AKUN</h3>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group full">
                    <label for="name">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus />
                    @error('name')<div class="input-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input id="nip" type="text" name="nip" value="{{ old('nip') }}" />
                    @error('nip')<div class="input-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="bidang">Bidang</label>
                    <input id="bidang" type="text" name="bidang" value="{{ old('bidang') }}" />
                    @error('bidang')<div class="input-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group full">
                    <label for="photo">Foto Profil (opsional)</label>
                    <input id="photo" type="file" name="photo" accept="image/*" />
                    @error('photo')<div class="input-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group full">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required />
                    @error('email')<div class="input-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required />
                    @error('password')<div class="input-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required />
                </div>
            </div>

            <button type="submit" class="btn-login">Daftar</button>

            <div style="width:100%; text-align:center; margin-top:0.5rem;">
                <a href="{{ route('login') }}" class="btn-login" style="display:inline-block; text-decoration:none; background:#006699;">Kembali ke Login</a>
            </div>
        </form>
    </div>
</body>

</html>
