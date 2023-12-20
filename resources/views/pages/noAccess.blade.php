@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
<div>
        <h1>vérifier vos identifiants d'accessibilité</h1>
        <a class="button button--primary rounded" aria-current="logout" href="{{ route("logout") }}">

         <i class="fa-solid fa-house"></i>
        </a>
</div>
</section>

@endsection
@php
$title = "No Access";
@endphp
