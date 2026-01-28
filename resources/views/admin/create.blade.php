<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Proizvod - Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .header {
            background: #2563eb;
            color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            margin-bottom: 30px;
            color: #333;
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
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn {
            padding: 12px 30px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Dodaj Novi Proizvod</h1>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Naziv proizvoda *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="price">Cena (RSD) *</label>
                    <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" required>
                </div>

                <div class="form-group">
                    <label for="image">Slika (URL ili naziv slike)</label>
                    <input type="text" id="image" name="image" value="{{ old('image') }}">
                </div>

                <div class="form-group">
                    <label for="category">Kategorija</label>
                    <input type="text" id="category" name="category" value="{{ old('category') }}">
                </div>

                <div class="form-group">
                    <label for="brand">Brend</label>
                    <input type="text" id="brand" name="brand" value="{{ old('brand') }}">
                </div>

                <div>
                    <button type="submit" class="btn">Sačuvaj Proizvod</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Otkaži</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
