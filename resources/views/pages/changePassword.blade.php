@extends('layouts.userLayout')
@section('pageContent')
<section class="section">
    <h2>changer le mot de passe</h2>
    <div class="form__container small">
        <livewire:change-password.change-password />
    </div>
</section>
@endsection
@php
$title = "changer Password";
@endphp

