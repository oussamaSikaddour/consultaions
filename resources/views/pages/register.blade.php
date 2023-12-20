@extends('layouts.guestLayout')

@section('pageContent')
    <section class="section">
        <h2>S'inscrire</h2>
        <div class="form__container small">
            <livewire:register.register-forms />
        </div>
    </section>
@endsection


@php
    $title = "S'inscrire";
@endphp
