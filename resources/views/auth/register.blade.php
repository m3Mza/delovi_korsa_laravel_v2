<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija - Delovi Korsa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #667eea;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .row {
            display: flex;
            gap: 15px;
        }

        .row .form-group {
            flex: 1;
        }

        @media (max-width: 600px) {
            .row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Registracija</h1>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row">
                <div class="form-group">
                    <label for="ime">Ime *</label>
                    <input type="text" id="ime" name="ime" value="{{ old('ime') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="prezime">Prezime *</label>
                    <input type="text" id="prezime" name="prezime" value="{{ old('prezime') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email adresa *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="lozinka">Lozinka * (minimum 6 karaktera)</label>
                <input type="password" id="lozinka" name="lozinka" required>
            </div>

            <div class="form-group">
                <label for="lozinka_confirmation">Potvrdi lozinku *</label>
                <input type="password" id="lozinka_confirmation" name="lozinka_confirmation" required>
            </div>

            <div class="form-group">
                <label for="telefon">Telefon</label>
                <input type="tel" id="telefon" name="telefon" value="{{ old('telefon') }}">
            </div>

            <div class="form-group">
                <label for="adresa">Adresa</label>
                <textarea id="adresa" name="adresa">{{ old('adresa') }}</textarea>
            </div>

            <button type="submit" class="btn">Registruj se</button>
        </form>

        <div class="links">
            <p>Već imate nalog? <a href="{{ route('login') }}">Prijavite se</a></p>
            <p><a href="{{ route('home') }}">Nazad na početnu</a></p>
        </div>
    </div>
</body>
</html>
