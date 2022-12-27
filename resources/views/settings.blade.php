@extends('shopify-app::layouts.default')

@section('content')
    <p class="text-2xl">Settings</p>
@endsection

@section('scripts')
    @parent

    <script>
        actions.TitleBar.create(app, {
            title: 'Settings'
        });
    </script>
@endsection
