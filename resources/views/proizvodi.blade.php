<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proizvodi - Mad Max</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@php
    $cartItemsCount = array_sum(array_column(session('cart', []), 'quantity'));
@endphp

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
                    <a href="/proizvodi" class="text-blue-600 font-semibold">Proizvodi</a>
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

    <!-- Header -->
    <div class="bg-blue-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold">Naši Proizvodi</h1>
            <p class="text-xl mt-2">Pronađite sve što vam je potrebno za vaš automobil</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar Filter -->
            <div class="md:w-64">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Kategorije</h3>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                            <button onclick="filterProducts('{{ $category }}')"
                                class="category-btn w-full text-left px-4 py-2 rounded hover:bg-blue-50 transition {{ $category === 'Sve' ? 'bg-blue-600 text-white hover:bg-blue-700' : 'text-gray-700' }}"
                                data-category="{{ $category }}">
                                {{ $category }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Search -->
                    <div class="mt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Pretraga</h3>
                        <input type="text" id="searchInput" placeholder="Pretražite delove..."
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            onkeyup="searchProducts()">
                    </div>

                    <!-- Filter Info -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            <span id="productCount">{{ count($products) }}</span> proizvoda
                        </p>
                    </div>
                </div>
            </div>

            <!-- Proizvodi Grid Prikaz -->
            <div class="flex-1">
                <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="product-card bg-white border rounded-lg p-4 hover:shadow-lg transition relative"
                            data-category="{{ $product->category }}" data-name="{{ strtolower($product->name) }}">
                            
                            <!-- Wishlist Heart Icon -->
                            @auth
                                <div class="absolute top-2 right-2 z-10">
                                    @if(in_array($product->id, $wishlistProductIds))
                                        <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-white rounded-full p-2 shadow-md hover:shadow-lg transition">
                                                <!-- Filled Heart -->
                                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-white rounded-full p-2 shadow-md hover:shadow-lg transition">
                                                <!-- Empty Heart -->
                                                <svg class="w-6 h-6 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endauth
                            
                            <div class="h-48 rounded mb-4 flex items-center justify-center overflow-hidden">
                                @if(!empty($product->image))
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="object-cover w-full h-full">
                                @else
                                    <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">Slika proizvoda</span>
                                    </div>
                                @endif
                            </div>
                            <span class="text-xs text-blue-600 font-semibold">{{ $product->category }}</span>
                            <h4 class="font-semibold text-lg mt-2">{{ $product->name }}</h4>
                            <p class="text-sm text-gray-500 mb-2">Brend: {{ $product->brand }}</p>
                            <p class="text-gray-600 text-sm mb-4">Visok kvalitet, originalni deo</p>
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
                                    <button
                                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Dodaj</button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- No Results -->
            <div id="noResults" class="hidden text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">🔍</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Nema rezultata</h3>
                <p class="text-gray-600">Pokušajte sa drugom pretragom ili kategorijom</p>
            </div>
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

    <script>
        function filterProducts(category) {
            const products = document.querySelectorAll('.product-card');
            const buttons = document.querySelectorAll('.category-btn');
            const noResults = document.getElementById('noResults');
            const productsGrid = document.getElementById('productsGrid');
            let visibleCount = 0;

            // Update button styles
            buttons.forEach(btn => {
                if (btn.dataset.category === category) {
                    btn.classList.remove('text-gray-700', 'bg-white');
                    btn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                } else {
                    btn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                    btn.classList.add('text-gray-700', 'bg-white');
                }
            });

            // Filter products
            products.forEach(product => {
                if (category === 'Sve' || product.dataset.category === category) {
                    product.style.display = 'block';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                productsGrid.classList.add('hidden');
                noResults.classList.remove('hidden');
            } else {
                productsGrid.classList.remove('hidden');
                noResults.classList.add('hidden');
            }

            // Update product count
            document.getElementById('productCount').textContent = visibleCount;

            // Clear search input
            document.getElementById('searchInput').value = '';
        }

        function searchProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const products = document.querySelectorAll('.product-card');
            const noResults = document.getElementById('noResults');
            const productsGrid = document.getElementById('productsGrid');
            let visibleCount = 0;

            // Reset category filter
            const buttons = document.querySelectorAll('.category-btn');
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                btn.classList.add('text-gray-700', 'bg-white');
            });

            products.forEach(product => {
                const productName = product.dataset.name;
                if (productName.includes(searchTerm)) {
                    product.style.display = 'block';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                productsGrid.classList.add('hidden');
                noResults.classList.remove('hidden');
            } else {
                productsGrid.classList.remove('hidden');
                noResults.classList.add('hidden');
            }

            // Update product count
            document.getElementById('productCount').textContent = visibleCount;
        }
    </script>
</body>

</html>