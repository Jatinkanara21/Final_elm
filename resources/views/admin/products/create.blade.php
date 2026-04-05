@extends('admin.layout')

@section('content')
<div class="mb-8 flex items-center space-x-4">
    <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-mocha-accent transition-colors">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h1 class="text-3xl font-serif font-bold text-mocha-text">Add New Product</h1>
</div>

<div class="bg-white rounded-2xl border border-gray-100 p-8 max-w-2xl shadow-sm">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-5">
            <x-input-label for="name" value="Product Name" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-5">
            <x-input-label for="category_id" value="Category" />
            <select name="category_id" id="category_id" class="mt-1 block w-full bg-white border border-gray-200 rounded-xl text-gray-700 focus:ring-mocha-accent focus:border-mocha-accent shadow-sm py-2 px-3" required>
                <option value="" disabled selected>Select a Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>


        <div class="mb-5">
            <x-input-label for="brand" value="Brand (Optional)" />
            <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full" value="{{ old('brand') }}" />
            <x-input-error :messages="$errors->get('brand')" class="mt-2" />
        </div>

        <div class="mb-5">
            <x-input-label for="description" value="Description" />
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full bg-white border border-gray-200 rounded-xl text-gray-700 focus:ring-mocha-accent focus:border-mocha-accent shadow-sm py-2 px-3">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Image Upload -->
        <div class="mb-6" x-data="imageUploader()">
            <x-input-label value="Product Image" />

            <div class="mt-2 relative border-2 border-dashed rounded-xl transition-colors duration-200 cursor-pointer"
                 :class="preview ? 'border-mocha-accent/40 bg-mocha-accent/5' : 'border-gray-200 hover:border-mocha-accent/40 bg-gray-50'"
                 @click="$refs.fileInput.click()"
                 @dragover.prevent="dragging = true"
                 @dragleave.prevent="dragging = false"
                 @drop.prevent="onDrop($event)">

                <!-- Empty state -->
                <div x-show="!preview" class="py-10 flex flex-col items-center justify-center text-center px-4">
                    <svg class="h-10 w-10 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm font-medium text-gray-600">Click or drag & drop to upload image</p>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, GIF up to 20MB</p>
                </div>

                <!-- Preview -->
                <div x-show="preview" class="relative p-4 flex items-center gap-4">
                    <img :src="preview" class="h-24 w-24 object-contain rounded-lg border border-gray-100 bg-white shadow-sm">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-700 truncate" x-text="fileName"></p>
                        <p class="text-xs text-gray-400 mt-0.5" x-text="fileSize"></p>
                        <button type="button" @click.stop="clearImage()" class="mt-2 text-xs text-red-500 hover:text-red-600 font-medium flex items-center gap-1">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            <input type="file" name="image" id="image" accept="image/*" class="hidden" x-ref="fileInput" @change="onFileChange($event)">
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                Create Product
            </x-primary-button>
        </div>
    </form>
</div>

<script>
function imageUploader(currentImage) {
    return {
        preview: currentImage || null,
        fileName: '',
        fileSize: '',
        dragging: false,
        onFileChange(event) {
            const file = event.target.files[0];
            if (file) this.loadFile(file);
        },
        onDrop(event) {
            this.dragging = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                this.$refs.fileInput.files = event.dataTransfer.files;
                this.loadFile(file);
            }
        },
        loadFile(file) {
            this.fileName = file.name;
            this.fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            const reader = new FileReader();
            reader.onload = (e) => { this.preview = e.target.result; };
            reader.readAsDataURL(file);
        },
        clearImage() {
            this.preview = null;
            this.fileName = '';
            this.fileSize = '';
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
@endsection
