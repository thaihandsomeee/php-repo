<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
            <a href="{{ route('albums.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Create New Album</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">My Albums</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse ($myAlbums as $album)
                            <a href="{{ route('albums.show', $album) }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h4 class="font-bold">{{ $album->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $album->photos->count() }} photos</p>
                            </a>
                        @empty
                            <p>You haven't created any albums yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Albums Shared With Me</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse ($sharedAlbums as $album)
                            <a href="{{ route('albums.show', $album) }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                                <h4 class="font-bold">{{ $album->title }}</h4>
                                <p class="text-sm text-gray-600">Shared by {{ $album->user->name }}</p>
                            </a>
                        @empty
                            <p>No albums have been shared with you.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>