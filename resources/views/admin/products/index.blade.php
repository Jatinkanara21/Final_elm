@extends('admin.layout')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-serif font-bold text-mocha-text mb-1">Manage Products</h1>
        <p class="text-gray-500 text-sm">View, create, and edit products.</p>
    </div>
    <div class="mt-4 sm:mt-0 flex gap-2">
        <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
            @csrf
            <label for="import_file" class="cursor-pointer inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-4 rounded-xl transition-all duration-200 shadow-sm text-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Select File
                <input type="file" name="import_file" id="import_file" class="hidden" onchange="this.form.submit()">
            </label>
            <span class="text-xs text-gray-400">CSV/XLSX only</span>
        </form>
        <form action="{{ route('admin.products.generate-all-images') }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="force" value="1">
            <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-200 shadow-sm text-sm active:scale-95" title="Force regenerate all images to 'Perfect' quality">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Force AI Regen
            </button>
        </form>
        <form action="{{ route('admin.products.sync-ubereats') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 bg-black hover:bg-gray-900 text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-200 shadow-sm text-sm" title="Sync all products to Uber Eats">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Sync Uber Eats
            </button>
        </form>
        <form action="{{ route('admin.products.deleteAll') }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete ALL products and their images? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-200 shadow-sm text-sm" title="Delete ALL products and their images">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete All
            </button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-mocha-accent hover:bg-[#A0522D] text-white font-semibold py-2.5 px-5 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md text-sm">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add New Product
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
        <input type="text" placeholder="Search products..." class="bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-700 focus:ring-mocha-accent focus:border-mocha-accent w-64 shadow-sm">
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($product->image)
                                <img class="h-12 w-12 rounded-xl object-cover bg-gray-100 p-0.5 border border-gray-100 shadow-sm" src="{{ Storage::url($product->image) }}" alt="">
                            @else
                                <div class="h-12 w-12 rounded-xl bg-mocha-accent/5 flex flex-col items-center justify-center border border-dashed border-mocha-accent/20 text-[8px] text-mocha-accent font-bold uppercase tracking-tighter text-center px-1">
                                    <svg class="w-4 h-4 mb-0.5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    AI Pending
                                </div>
                            @endif
                            <div class="ml-4">
                                <div class="text-sm font-bold text-mocha-text">{{ $product->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-mocha-accent hover:text-[#A0522D] font-bold mr-3">Edit</a>
                        @if(!$product->image)
                            <form action="{{ route('admin.products.generate-image', $product) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-purple-600 hover:text-purple-700 font-bold mr-3" title="Generate AI Image">AI Gen</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600 font-bold" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $products->links() }}
    </div>
</div>
@endsection
