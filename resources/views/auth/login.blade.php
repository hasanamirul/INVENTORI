<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventori Barang</title>
   <link rel="icon" type="image/png" href="{{ asset('boxes.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
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
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        }

        .logo {
            display: block;
            margin: 0 auto 1rem auto;
            width: 80px;
            height: auto;
        }

        h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #004d80;
            margin-bottom: 0.5rem;
        }

        h3 {
            font-size: 1.5rem;
            font-weight: 750;
            color: #006699;
            margin-bottom: 2rem;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center; /* center input form horizontal */
            gap: 1rem;
        }

        .form-group {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* label kiri */
        }

        label {
            font-weight: 600;
            color: #004d80;
            margin-bottom: 0.25rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 2px solid #006699;
            transition: all 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #004d80;
            box-shadow: 0 0 8px rgba(0, 77, 128, 0.4);
        }

        .remember-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #004d80;
            align-self: flex-start; /* checkbox kiri */
        }

        input[type="checkbox"] {
            accent-color: #004d80;
        }

        .btn-login {
            background-color: #006699;
            color: #fff;
            font-weight: 800;
            padding: 0.75rem 1.5rem;
            border-radius: 3rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 90%; /* tombol lebih kecil dan center */
            align-self: center;
        }

        .btn-login:hover {
            background-color: #004d80;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        }

        .forgot-link {
            font-size: 0.9rem;
            color: #004d80;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #006699;
        }

        .input-error {
            color: #e02424;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 2rem 1.5rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            h3 {
                font-size: 1rem;
            }

            .btn-login {
                width: 70%;
                padding: 0.65rem 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="{{ asset('pemprov.png') }}" alt="Logo" class="logo">
        <h2>DISPERMADESDUKCAPIL PROVINSI JATENG</h2>
        <h3>INVENTORI BARANG</h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus>
                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-container">
                <input type="checkbox" name="remember" id="remember_me">
                <span>Remember me</span>
            </div>

            

            <button type="submit" class="btn-login">Log In</button>
        </form>
    </div>
</body>

</html>
