

<div class="group relative bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
    <div class="h-64 bg-gray-100 relative overflow-hidden">
        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur text-red-900 text-xs font-bold px-2 py-1 rounded-full uppercase tracking-wider">
            {{ $wine->vintage }}
        </span>
    </div>

    <div class="p-5">
        <div class="flex justify-between items-start mb-2">
            <div>
                <p class="text-sm text-green-700 font-medium">{{ $wine->variety }}</p>
                <h3 class="text-xl font-serif text-gray-900 font-bold">{{ $wine->batch_number }}</h3>
            </div>
        </div>
        
        <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                {{ $wine->alcohol_percentage }}% Alk.
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Archive
            </span>
        </div>

        <form action="{{ route('cart.add', $wine) }}" method="POST">
            @csrf
            <button class="w-full bg-[#722F37] hover:bg-[#5a242b] text-white font-medium py-2 rounded transition-colors flex justify-center items-center gap-2">
                Add to cart
            </button>
        </form>
    </div>
</div>