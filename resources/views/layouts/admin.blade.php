<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winery Andrej</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#F9F7F2] text-gray-800">

    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-[#722F37] text-white flex flex-col shadow-2xl">
            <div class="p-6 text-center border-b border-white/10">
                <h1 class="text-2xl font-bold serif tracking-wide">Winery<br>Andrej</h1>
            </div>
            
            <nav class="flex-1 py-6 space-y-1">
                <a href="#" class="flex items-center px-6 py-3 bg-white/10 border-r-4 border-[#4A5D23]">
                    <span class="font-medium">Vineyard Overview</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-white/5 transition">
                    <span class="font-medium opacity-80">Treatment Planning</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-white/5 transition">
                    <span class="font-medium opacity-80">Storage & Harvest</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-white/5 transition">
                    <span class="font-medium opacity-80">Orders</span>
                </a>
            </nav>

            <div class="p-4 bg-[#5a242b]">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gray-300"></div>
                    <div>
                        <p class="text-sm font-bold">Andrej</p>
                        <p class="text-xs opacity-70">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
                <h2 class="text-xl text-gray-700 font-bold">Dashboard</h2>
                <button class="bg-[#4A5D23] hover:bg-[#3a4a1b] text-white px-4 py-2 rounded-lg shadow text-sm transition">
                    + Nová úloha
                </button>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>