@extends('shopify-app::layouts.default')

@section('content')
    <p class="text-2xl">Products</p>
@endsection

@section('scripts')
    @parent

    <script>
        actions.TitleBar.create(app, {
            title: 'Products'
        });
    </script>
@endsection
