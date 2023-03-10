<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user();

        $shopWishlist = Wishlist::where('shop_id', $shop->name)
            ->select('product_id')
            ->selectRaw('COUNT(product_id) AS count')
            ->groupBy('product_id')
            ->orderBy('product_id', 'desc')
            ->get();

        $shopWishlist = $shopWishlist->unique('product_id');
        $productsList = [];

        foreach ($shopWishlist as $item) {
            array_push($productsList, "gid://shopify/Product/{$item->product_id}");
        }

        $productsList = json_encode($productsList);

        $query = "
        {
            nodes(ids: $productsList) {
              ... on Product {
                id
                title
                handle
                featuredImage{
                    url
                  }
                onlineStoreUrl
                totalInventory
              }
            }
          }
        ";

        $products = $shop->api()->graph($query);

        // map through the data returned from shopify, check product_id and match them, push count to the single product array

        $returnedProducts = $products['body']->container['data']['nodes'];
        $newArray = [];

        // foreach ($returnedProducts as $shopifyProduct) {
        //     foreach ($shopWishlist as $countItem) {
        //         if (str_contains($shopifyProduct['id'], $countItem['product_id'])) {
        //             array_push($newArray, $countItem['count']);
        //         } else {
        //             array_push($newArray, "count => 0");
        //         };
        //     }
        // }

        for ($i = 0; $i < count($returnedProducts); $i++) {
            $returnedProducts[$i]['count'] = $shopWishlist[$i]['count'];
        }

        $containesId = str_contains($products['body']->container['data']['nodes'][0]['id'], $shopWishlist[0]['product_id']);

        return view('products', [
            "products" => $returnedProducts,
            "productList" => $shopWishlist,
            "containsID" => $returnedProducts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Wishlist::updateOrCreate([
            "shop_id" => $request->shop_id,
            "customer_id" => $request->customer_id,
            "product_id" => $request->product_id
        ]);
        return response("Added to wishlist", 201);
    }

    /**
     * Display/check the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $existsOrNot = Wishlist::where('shop_id', $request->shop_id)->where('product_id', $request->product_id)->where('customer_id', $request->customer_id)->exists();

        return response($existsOrNot);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Wishlist::where('shop_id', $request->shop_id)->where('product_id', $request->product_id)->where('customer_id', $request->customer_id)->first();

        Wishlist::destroy($product->id);

        return response('Wishlist item removed', 200);
    }
}
