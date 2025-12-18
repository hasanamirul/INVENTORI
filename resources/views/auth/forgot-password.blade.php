<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Inventori Barang</title>
   <link rel="icon" type="image/png" href="{{ asset('boxes.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Match login styles for consistent spacing */
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
            max-width: 400px;
            width: 90%;
            padding: 2rem 2rem;
            text-align: center;
        }

        .logo { display:block; margin:0 auto 1rem; width:80px }
        h2 { font-size:1.75rem; font-weight:800; color:#004d80; margin-bottom:0.5rem }
        h3 { font-size:1.5rem; font-weight:750; color:#006699; margin-bottom:1.5rem }

        form { display:flex; flex-direction:column; gap:1rem; align-items:center }
        .form-group { width:100%; display:flex; flex-direction:column; align-items:flex-start }
        label { font-weight:600; color:#004d80; margin-bottom:0.25rem }

        input[type="email"] { width:90%; padding:0.75rem 1rem; border-radius:0.75rem; border:2px solid #006699 }
        input:focus { outline:none; border-color:#004d80; box-shadow:0 0 8px rgba(0,77,128,0.4) }

        .btn-login { background-color:#006699; color:#fff; font-weight:800; padding:0.75rem 1.5rem; border-radius:3rem; border:none; cursor:pointer; width:90% }
        .btn-login:hover { background-color:#004d80; transform:translateY(-2px); box-shadow:0 6px 18px rgba(0,0,0,0.25) }

        .btn-secondary { background:#34a853; color:#fff; padding:0.5rem 0.75rem; border-radius:999px; text-decoration:none; display:inline-block }

        .input-error { color:#e02424; font-size:0.85rem; margin-top:0.25rem }

        @media (max-width:576px) { .btn-login{width:70%} }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="{{ asset('pemprov.png') }}" alt="Logo" class="logo">
        <h2>DISPERMADESDUKCAPIL PROVINSI JATENG</h2>
        <h3>RESET PASSWORD</h3>

        <div style="width:100%; text-align:left; color:#334155; margin-bottom:0.5rem">{{ __('Forgot your password? No problem. Enter your email and we will send a link to reset it.') }}</div>

        @if(session('status'))
            <div style="width:100%; text-align:left; color:green; margin-bottom:0.5rem">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />
                @error('email')<div class="input-error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn-login">Kirim Link Reset</button>

            <div style="width:100%; text-align:center; margin-top:0.5rem;">
                <a href="{{ route('login') }}" class="btn-login" style="display:inline-block; text-decoration:none; background:#006699;">Kembali ke Login</a>
            </div>
        </form>
    </div>
</body>

</html>
