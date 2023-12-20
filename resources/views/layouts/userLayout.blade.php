@extends("layouts.rootLayout")
@section("content")
<x-user.header />
<main class="container">
    @yield("pageContent")
</main>
<x-user.footer />
@endsection
