@extends('layouts.admin')

@section('content')

    @if(count($alerts) > 0)
        <div class="mb-6 space-y-2">
            @foreach($alerts as $alert)
                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded shadow-sm flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <div>
                        <h3 class="text-red-800 font-bold">Safety Warning</h3>
                        <p class="text-red-700 text-sm">{{ $alert }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm uppercase font-semibold tracking-wider">Active rows</p>
            <p class="text-3xl font-bold text-[#722F37] mt-1">{{ count($rows) }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm uppercase font-semibold tracking-wider">Next collection</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">
                {{ \Carbon\Carbon::now()->addDays(2)->format('d.m.') }}
            </p>
            <p class="text-xs text-gray-400">Rizling Vlašský</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 bg-gradient-to-br from-[#4A5D23] to-[#3a4a1b] text-white">
            <p class="opacity-80 text-sm uppercase font-semibold tracking-wider">Weather (Wineyard)</p>
            <div class="flex items-center gap-3 mt-2">
                <span class="text-3xl font-bold">24°C</span>
                <span class="text-sm opacity-90">Sunny</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-lg text-gray-800">Condition of Vineyard Rows</h3>
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Season 2025</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Marking</th>
                        <th class="px-6 py-4">Variety</th>
                        <th class="px-6 py-4">Last Treatment</th>
                        <th class="px-6 py-4">Planned collection</th>
                        <th class="px-6 py-4">State</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($rows as $row)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-700">{{ $row['id'] }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                {{ $row['variety'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="text-gray-900 font-medium">{{ $row['last_treatment_type'] }}</div>
                            <div class="text-gray-500 text-xs">{{ $row['last_treatment_date']->format('d.m.Y') }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $row['planned_harvest']->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($row['status'] == 'warning')
                                <span class="inline-flex items-center gap-1 text-red-600 bg-red-50 px-2 py-1 rounded text-xs font-bold">
                                    <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></span> Risk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-green-700 bg-green-50 px-2 py-1 rounded text-xs font-bold">
                                    <span class="w-2 h-2 bg-green-600 rounded-full"></span> OK
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-gray-400 hover:text-[#722F37] font-medium text-sm">Detail</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection