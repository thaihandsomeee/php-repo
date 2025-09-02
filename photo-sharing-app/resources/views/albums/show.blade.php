<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $album->title }}</h2>
            @can('manage-album', $album)
                <div class="flex space-x-2">
                     <a href="{{ route('albums.share', $album) }}" class="text-sm text-black bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded">Share</a>
                     <a href="{{ route('albums.edit', $album) }}" class="text-sm text-black bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded">Edit</a>
                </div>
            @endcan
        </div>
        <p class="text-sm text-gray-600 mt-1">{{ $album->description }}</p>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            @can('manage-album', $album)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upload New Photo</h3>
                    <form action="{{ route('albums.photos.store', $album) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-input-label for="photo" value="Photo File (Max 10MB)" />
                            <x-text-input id="photo" name="photo" type="file" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="title" value="Photo Title (Optional)" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" />
                        </div>
                        <div class="mt-4"><x-primary-button>Upload</x-primary-button></div>
                    </form>
                </div>
            </div>
            @endcan

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Photos in this Album</h3>
                    @if ($album->photos->isEmpty())
                        <p>This album is empty.</p>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach ($album->photos as $photo)
                                <div class="relative group">
                                     <a href="{{ route('photos.show', $photo) }}">
                                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->title }}" class="w-full h-48 object-cover rounded-lg">
                                    </a>
                                    @can('manage-photo', $photo)
                                        <form action="{{ route('photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="">&times; Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>