
<x-layout>
    <x-slot:title>
        Winery Andrej
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow mt-8">
            <div class="card-body">
                <div>
                    <h1 class="text-3xl font-bold">Welcome to Chirper!</h1>
                    <p class="mt-4 text-base-content/60">
                        This is your brand new Laravel application. Time to make it
                        sing (or chirp)!
                    </p>

                    <h2 class="text-xl font-semibold mt-6">Users (for testing DB):</h2>

                    <ul class="list-disc ml-6 mt-3">
                        @foreach($users as $user)
                            <li>{{ $user->name }} ({{ $user->role }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layout>