<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mad Max</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<!-- Ovo prati stanje korpe na svim stranicama -->
@php
    $cartItemsCount = array_sum(array_column(session('cart', []), 'quantity'));
@endphp

<body class="bg-gray-50">
    <!-- Navigacioni meni -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Mad Max</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-700 hover:text-blue-600">Početna</a>
                    <a href="/proizvodi" class="text-gray-700 hover:text-blue-600">Proizvodi</a>
                    <a href="/o-nama" class="text-gray-700 hover:text-blue-600">O Nama</a>
                    
                    @auth
                        <a href="/wishlist" class="text-gray-700 hover:text-blue-600">Lista Želja</a>
                        @if(Auth::user()->isAdmin())
                            <a href="/admin/dashboard" class="text-gray-700 hover:text-blue-600">Admin Panel</a>
                        @endif
                        <span class="text-gray-600">{{ Auth::user()->ime }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Odjavi se</button>
                        </form>
                    @else
                        <a href="/login" class="text-gray-700 hover:text-blue-600">Prijava</a>
                    @endauth
                    
                    <a href="/korpa" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Korpa ({{ $cartItemsCount }})
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="bg-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Kvalitetni Auto Delovi za Vaš Automobil</h2>
            <p class="text-xl mb-8">Brza dostava | Povoljne cene | Originalni delovi</p>
            <a href="/proizvodi"
                class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 inline-block">Pretraži
                Delove</a>
        </div>
    </div>

    <!-- Kategorije dekoracija -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-8">Kategorije</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition cursor-pointer">
                <div class="text-blue-600 text-4xl mb-3">🔧</div>
                <h4 class="font-semibold text-lg">Motor</h4>
                <p class="text-gray-600 text-sm">Delovi motora</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition cursor-pointer">
                <div class="text-blue-600 text-4xl mb-3">🛞</div>
                <h4 class="font-semibold text-lg">Kočnice</h4>
                <p class="text-gray-600 text-sm">Sistem kočenja</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition cursor-pointer">
                <div class="text-blue-600 text-4xl mb-3">⚙️</div>
                <h4 class="font-semibold text-lg">Transmisija</h4>
                <p class="text-gray-600 text-sm">Delovi transmisije</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition cursor-pointer">
                <div class="text-blue-600 text-4xl mb-3">💡</div>
                <h4 class="font-semibold text-lg">Elektrika</h4>
                <p class="text-gray-600 text-sm">Električni delovi</p>
            </div>
        </div>
    </div>

    <!-- Random izlog -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-8">Izdvojeni Proizvodi</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <div class="border rounded-lg p-4 hover:shadow-lg transition">
                        <div class="bg-gray-200 h-48 rounded mb-4 flex items-center justify-center overflow-hidden">
                            @if(!empty($product->image))
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    class="object-cover w-full h-full">
                            @else
                                <span class="text-gray-400 text-sm">Slika proizvoda</span>
                            @endif
                        </div>
                        <span class="text-xs text-blue-600 font-semibold">{{ $product->category }}</span>
                        <h4 class="font-semibold text-lg mt-2">{{ $product->name }}</h4>
                        <p class="text-gray-600 text-sm mb-4">Opis proizvoda ide ovde</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-800">{{ $product->price }} RSD</span>


                            <!-- dugme za dodavanje u korpu -->
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="hidden" name="category" value="{{ $product->category }}">
                                <input type="hidden" name="quantity" value="1">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Dodaj</button>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h5 class="font-bold text-lg mb-4">Mad Max delovi za automobile</h5>
                    <p class="text-gray-400">Da se sve lampice pogase!</p>
                </div>
                <div>
                    <h5 class="font-bold text-lg mb-4">Kontakt</h5>
                    <p class="text-gray-400">Email: madmax@gmail.com</p>
                    <p class="text-gray-400">Telefon: +381 11 123 4567</p>
                </div>
                <div>
                    <h5 class="font-bold text-lg mb-4">Radno Vreme</h5>
                    <p class="text-gray-400">Pon-Pet: 08:00 - 17:00</p>
                    <p class="text-gray-400">Subota: 08:00 - 14:00</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025. Sva prava zadržana.</p>
            </div>
        </div>
    </footer>
</body>

</html>