@extends('layouts.guestLayout')
@section('pageContent')
    <section class="section">
        <h2>réinitialiser le mot de passe</h2>
        <div class="form__container small">
            <livewire:forget-password.forms />
        </div>
    </section>
@endsection

@php
$title = "réinitialiser Password";
@endphp

