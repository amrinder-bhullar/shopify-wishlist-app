<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shop = Auth::user();
        $themes = $shop->api()->rest('GET', '/admin/themes.json');

        $activeThemeId = "";
        foreach ($themes['body']->container['themes'] as $theme) {
            if ($theme['role'] == "main") {
                $activeThemeId = $theme['id'];
            }
        }

        $snippet = "Your snippet code here";

        $array = array('asset' => array('key' => 'snippets/wishlist-appblock.liquid', 'value' => $snippet));

        $shop->api()->rest('PUT', '/admin/themes/' . $activeThemeId . '/assets.json', $array);

        // Save data to database

        Settings::updateOrCreate([
            'shop_id' => $shop->name,
            'activated' => true
        ]);

        return response(["success" => 'App block added correctly'], 200);
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
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
