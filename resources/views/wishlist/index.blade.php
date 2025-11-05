<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moja Lista Želja - Delovi Korsa</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h1 {
            font-size: 24px;
        }

        .header-actions a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            margin-left: 10px;
        }

        .header-actions a:hover {
            background: rgba(255,255,255,0.3);
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

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .product-price {
            font-size: 20px;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .btn-remove {
            width: 100%;
            padding: 10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-remove:hover {
            background: #c82333;
        }

        .empty-wishlist {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 10px;
            margin-top: 20px;
        }

        .empty-wishlist p {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }

        .empty-wishlist a {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .empty-wishlist a:hover {
            background: #5568d3;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Moja Lista Želja</h1>
            <div class="header-actions">
                <a href="{{ route('home') }}">Početna</a>
                @auth
                    <span>{{ Auth::user()->ime }}</span>
                @endauth
            </div>
        </div>
    </div>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($wishlist->count() > 0)
            <div class="products-grid">
                @foreach($wishlist as $proizvod)
                    <div class="product-card">
                        <div class="product-image">
                            @if($proizvod->slika)
                                <img src="{{ asset('img/' . $proizvod->slika) }}" alt="{{ $proizvod->naziv }}">
                            @else
                                <span>Nema slike</span>
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-name">{{ $proizvod->naziv }}</div>
                            <div class="product-price">{{ number_format($proizvod->cena, 2) }} RSD</div>
                            <form method="POST" action="{{ route('wishlist.remove', $proizvod->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">Ukloni iz liste</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-wishlist">
                <p>Vaša lista želja je prazna.</p>
                <a href="{{ route('home') }}">Pregledaj proizvode</a>
            </div>
        @endif
    </div>
</body>
</html>
