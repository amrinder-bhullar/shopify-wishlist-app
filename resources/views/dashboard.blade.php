@extends('shopify-app::layouts.default')

@if (!$settings or !$settings->activated)
    @include('partials.activate-modal')
@endif

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- This is an example component -->
        <div id="wrapper" class="container px-4 py-4 mx-auto">
            <div class="sm:grid sm:h-32 sm:grid-flow-row sm:gap-4 sm:grid-cols-3">
                {{-- {{ dd($dashboardData) }} --}}
                <x-status type="positive" title="Today's wishists" number="{{ $dashboardData['todayWishlist'] }}"
                    growth="9" />
                <x-status type="negative" title="Yesterday's wislists" number="{{ $dashboardData['yesterdayWishlist'] }}"
                    growth="20" />
                <x-status type="normal" title="Total wislists" number="{{ $dashboardData['totalWishlist'] }}"
                    growth="0" />

            </div>
        </div>
        <div class="max-w-72 max-h-72 flex justify-end">
            @include('partials.charts-svg')
        </div>
        <x-singleLineTable title="Latest wishlisted Product" :product="$dashboardData['latestProduct']" count="1" />
        <x-singleLineTable title="Most wishlisted Product" :product="$dashboardData['mostWishlistedItem']" :count="$dashboardData['mostWishlistedItemCount']" />
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        actions.TitleBar.create(app, {
            title: 'Welcome'
        });

        function setUpTheme() {

        }
    </script>
@endsection
