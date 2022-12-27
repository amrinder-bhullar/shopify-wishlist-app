@extends('shopify-app::layouts.default')

@section('content')
    <p class="text-2xl">Customers</p>
@endsection

@section('scripts')
    @parent

    <script>
        actions.TitleBar.create(app, {
            title: 'customers'
        });
    </script>
@endsection
