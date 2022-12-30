@props(['product', 'title', 'count'])


<div class="overflow-x-auto relative mt-6 bg-white border border-gray-300">
    <h3 class="text-xl p-3">{{ $title }}</h3>
    <table class="w-full text-sm text-center">
        {{-- <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">
                    Product name
                </th>
                <th scope="col" class="py-3 px-6">
                    Color
                </th>
                <th scope="col" class="py-3 px-6">
                    Category
                </th>
                <th scope="col" class="py-3 px-6">
                    Price
                </th>
            </tr>
        </thead> --}}
        <tbody>
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
                    Wishlisted: {{ $count }} times
                </td>
                <td class="py-4 px-6">
                    {{ $product['totalInventory'] }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
