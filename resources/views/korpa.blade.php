<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korpa - Mad Max</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <!-- Navigacija -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-gray-800">Mad Max</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-700 hover:text-blue-600">Početna</a>
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
                    
                    <a href="/korpa" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Korpa ({{ count($cartItems ?? []) }})</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-blue-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-2">Vaša Korpa</h1>
            <p class="text-lg text-blue-100">Pregled i uređivanje porudžbine</p>
        </div>
    </div>

    <!-- Sadrzaj korpe -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(empty($cartItems))
            <div class="text-center py-20">
                <p class="text-gray-600 text-lg mb-6">Vaša korpa je trenutno prazna.</p>
                <a href="/proizvodi" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 inline-block">Nastavi kupovinu</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Predmeti u korpi -->
                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">Proizvodi u korpi</h2>

                    <div class="divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                        <div class="flex items-center justify-between py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-20 h-20 bg-gray-100 rounded flex items-center justify-center">
                                    <span class="text-gray-400 text-sm">Slika</span>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $item['name'] }}</h3>
                                    <p class="text-gray-500 text-sm">{{ $item['category'] }}</p>
                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 text-sm hover:underline">Ukloni</button>
                                    </form>
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="flex items-center space-x-2 mb-2">
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 border border-gray-300 rounded p-1 text-center">
                                        <button class="text-blue-600 text-sm hover:underline">Ažuriraj</button>
                                    </form>
                                </div>
                                <span class="text-lg font-semibold text-gray-800">{{ $item['price'] }} RSD</span>


                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Summary -->
                <div class="bg-white p-6 rounded-lg shadow h-fit">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">Sažetak porudžbine</h2>
                    <div class="space-y-2 text-gray-700">
                        <div class="flex justify-between">
                            <span>Ukupno proizvoda:</span>
                            <span>{{ count($cartItems) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Međuzbir:</span>
                            <span>{{ $subtotal }} RSD</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Dostava:</span>
                            <span>{{ $delivery ?? 'Besplatna' }}</span>
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-between font-bold text-lg text-gray-800">
                            <span>Ukupno:</span>
                            <span>{{ $total }} RSD</span>
                        </div>
                    </div>
                    <a href="/checkout" class="block bg-blue-600 text-white text-center py-3 mt-6 rounded-lg font-semibold hover:bg-blue-700">Nastavi na plaćanje</a>
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h5 class="font-bold text-lg mb-4">Mad Max delovi za Opel</h5>
                    <p class="text-gray-400">Vaš pouzdani partner za sve Opel!</p>
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
