@extends('admin.layout')

@section('content')
<div class="mb-8 flex items-center space-x-4">
    <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-mocha-accent transition-colors">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h1 class="text-3xl font-serif font-bold text-mocha-text">Add New Category</h1>
</div>

<div class="bg-white rounded-2xl border border-gray-100 p-8 max-w-lg shadow-sm">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-5">
            <x-input-label for="name" value="Category Name" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="description" value="Description" />
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full bg-white border border-gray-200 rounded-xl text-gray-700 focus:ring-mocha-accent focus:border-mocha-accent shadow-sm py-2 px-3">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                Create Category
            </x-primary-button>
        </div>
    </form>
</div>
@endsection
