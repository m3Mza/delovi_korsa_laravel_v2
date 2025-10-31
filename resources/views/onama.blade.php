<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Nama - Mad Max</title>
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
                    <a href="/proizvodi" class="text-gray-700 hover:text-blue-600">Proizvodi</a>
                    <a href="/o-nama" class="text-blue-600 font-semibold">O Nama</a>
                    <a href="/korpa" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Korpa ({{ $cartItemsCount }})
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="bg-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold">O Nama</h1>
            <p class="text-xl mt-4">Jeftini i originalni delovi za širok spektar kola</p>
        </div>
    </div>

    <!-- O nama segment -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- 1 -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Naša Priča</h2>
            <p class="text-gray-700 mb-4 leading-relaxed">
                "Mad Max" delovi za Opel je veb aplikacija kreirana sa namerom da pruži brz i jednostavan način da
                naručite delove za vaš automobil!
            </p>
            <p class="text-gray-700 mb-4 leading-relaxed">
                Sve što vam treba od motora do elektrike pa i filtera, u par klikova, bez odlaska kod mehaničara.
            </p>
        </div>

        <!-- Mission & Vision -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-blue-600 text-3xl mb-3">🎯</div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Naša Misija</h3>
                <p class="text-gray-700">
                    Kvalitetni delovi po pristupačnim cenama, naručeni i dostavljeni u brzom roku za naše mušterije.
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-blue-600 text-3xl mb-3">👁️</div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Naša Vizija</h3>
                <p class="text-gray-700">
                    Opel korsa bez upaljenih lampica.
                </p>
            </div>
        </div>

        <!-- 2 -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Zašto Izabrati Nas?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start">
                    <div class="text-blue-600 text-2xl mr-4">✓</div>
                    <div>
                        <h4 class="font-semibold text-lg text-gray-800">Originalni Delovi</h4>
                        <p class="text-gray-600">Garantujemo autentičnost svih naših proizvoda</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="text-blue-600 text-2xl mr-4">✓</div>
                    <div>
                        <h4 class="font-semibold text-lg text-gray-800">Brza Dostava</h4>
                        <p class="text-gray-600">Isporuka u roku od 24-48h širom Srbije</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="text-blue-600 text-2xl mr-4">✓</div>
                    <div>
                        <h4 class="font-semibold text-lg text-gray-800">Stručna Podrška</h4>
                        <p class="text-gray-600">Naš tim vam je uvek na raspolaganju</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="text-blue-600 text-2xl mr-4">✓</div>
                    <div>
                        <h4 class="font-semibold text-lg text-gray-800">Povoljne Cene</h4>
                        <p class="text-gray-600">Najbolji kvalitet po najboljoj ceni</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3 -->
    <div class="bg-gray-100 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Kontaktirajte Nas</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-blue-600 text-3xl mb-3">📍</div>
                    <h4 class="font-semibold text-lg mb-2">Adresa</h4>
                    <p class="text-gray-600">Svetosavska 3</p>
                    <p class="text-gray-600">23300 Kikinda, Srbija</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-blue-600 text-3xl mb-3">📧</div>
                    <h4 class="font-semibold text-lg mb-2">Email</h4>
                    <p class="text-gray-600">madmax@gmail.com</p>
                    <p class="text-gray-600">madmaxpodrska@gmail.com</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-blue-600 text-3xl mb-3">📞</div>
                    <h4 class="font-semibold text-lg mb-2">Telefon</h4>
                    <p class="text-gray-600">+381 11 123 4567</p>
                    <p class="text-gray-600">+381 64 123 4567</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 mt-6 text-center">
                <h4 class="font-semibold text-lg mb-3">Radno Vreme</h4>
                <div class="text-gray-600">
                    <p>Ponedeljak - Petak: 08:00 - 17:00</p>
                    <p>Subota: 08:00 - 14:00</p>
                    <p>Nedelja: Zatvoreno</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
                <p>&copy; 2025. Sva prava zadržana.</p>
            </div>
        </div>
    </footer>
</body>

</html>