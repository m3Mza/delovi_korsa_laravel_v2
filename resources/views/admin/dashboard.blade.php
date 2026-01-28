<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Delovi Korsa</title>
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
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .header-actions a,
        .header-actions form button {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .header-actions a:hover,
        .header-actions form button:hover {
            background: rgba(255,255,255,0.3);
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .top-actions {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .products-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-edit {
            padding: 5px 10px;
            background: #ffc107;
            color: #333;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
        }

        .btn-delete {
            padding: 5px 10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-edit:hover {
            background: #e0a800;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .no-products {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Admin Panel - Upravljanje Proizvodima</h1>
            <div class="header-actions">
                <span>Dobrodošli, {{ Auth::user()->ime }}!</span>
                <a href="{{ route('home') }}">Početna</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit">Odjavi se</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="top-actions">
            <a href="{{ route('admin.create') }}" class="btn">+ Dodaj Novi Proizvod</a>
        </div>

        <div class="products-table">
            @if($proizvodi->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Naziv</th>
                            <th>Cena (RSD)</th>
                            <th>Kategorija</th>
                            <th>Stanje</th>
                            <th>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proizvodi as $proizvod)
                            <tr>
                                <td>{{ $proizvod->id }}</td>
                                <td>{{ $proizvod->name ?? $proizvod->naziv ?? 'N/A' }}</td>
                                <td>{{ $proizvod->price ?? $proizvod->cena ?? 0 }}</td>
                                <td>{{ $proizvod->category ?? $proizvod->kategorija ?? 'N/A' }}</td>
                                <td>{{ $proizvod->stanje ?? 0 }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.edit', $proizvod->id) }}" class="btn-edit">Izmeni</a>
                                        <form method="POST" action="{{ route('admin.destroy', $proizvod->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="return confirm('Da li ste sigurni da želite da obrišete ovaj proizvod?')">Obriši</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-products">
                    <p>Nema proizvoda u bazi.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
