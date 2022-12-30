@extends('shopify-app::layouts.default')

@section('content')
    <div class="max-w-72 max-h-72 flex justify-end">
        @include('partials.wishlisted-products-svg')
    </div>
    {{-- {{ dd($productList, $products, $containsID) }} --}}
    <div class="overflow-x-auto relative mt-6">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">
                        Product name
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Products
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Wishlisted
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Inventory
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="bg-white border-b">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            <a href="{{ $product['onlineStoreUrl'] }}" target="_blank" rel="noopener noreferrer"><img
                                    class="w-20 h-20" src="{{ $product['featuredImage']['url'] }}"></a>
                        </th>
                        <td class="py-4 px-6">
                            <a href="{{ $product['onlineStoreUrl'] }}" target="_blank"
                                rel="noopener noreferrer">{{ $product['title'] }}</a>
                        </td>
                        <td class="py-4 px-6">
                            {{ $product['count'] }}
                        </td>
                        <td class="py-4 px-6 {{ $product['totalInventory'] == 0 ? 'text-red-500' : 'text-green-500' }}">
                            {{ $product['totalInventory'] == 0 ? 'out of stock' : $product['totalInventory'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        actions.TitleBar.create(app, {
            title: 'Products'
        });
    </script>
@endsection
