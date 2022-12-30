<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user();
        $setting = Settings::where("shop_id", $shop->name)->first();

        $latestWishlistedProduct = "gid://shopify/Product/" . Wishlist::where('shop_id', $shop->name)->latest()->first()->product_id;

        $mostWishlistedProduct = Wishlist::where('shop_id', $shop->name)
            ->select('product_id')
            ->selectRaw('COUNT(*) AS count')
            ->groupBy('product_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->first();

        $mostWishlistedProductId = "gid://shopify/Product/" . $mostWishlistedProduct->product_id;

        $productsList = [$latestWishlistedProduct, $mostWishlistedProductId];

        // foreach ($shopWishlist as $item) {
        //     array_push($productsList, "gid://shopify/Product/{$item->product_id}");
        // }

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
        // {
        //     product(id: ${mostWishlistedProductId}) {
        // title
        // featuredImage{
        //           url
        //         }
        //         onlineStoreUrl
        //         totalInventory
        //     }
        // }


        $latestWishlistedProductData = $shop->api()->graph($query);

        $dashboardData = [
            "todayWishlist" => Wishlist::where('created_at', 'LIKE', '%' . Carbon::now()->today()->toDateString() . '%')->get()->count(),
            "yesterdayWishlist" => Wishlist::where('created_at', 'LIKE', '%' . Carbon::now()->yesterday()->toDateString() . '%')->get()->count(),
            "totalWishlist" => Wishlist::all()->count(),
            "latestProduct" => $latestWishlistedProductData['body']['container']['data']['nodes'][0],
            "mostWishlistedItem" => $latestWishlistedProductData['body']['container']['data']['nodes'][1],
            "mostWishlistedItemCount" => $mostWishlistedProduct->count,
        ];

        return view('dashboard', [
            "settings" => $setting,
            "dashboardData" => $dashboardData,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
