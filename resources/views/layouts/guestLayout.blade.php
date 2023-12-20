@php
    $customCSS = true; // Define your custom CSS variable here, set to true or false based on your
@endphp

@extends("layouts.rootLayout",['customCSS' => $customCSS])
@section("content")
<x-guest.header :$customCSS/>
<main class="container__custom">
@yield("pageContent")
</main>
@endsection
