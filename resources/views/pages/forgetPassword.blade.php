@extends('layouts.guestLayout')
@section('pageContent')
    <section class="section">
        <h2>@lang('pages.forget-password.main-title')</h2>
        <div class="form__container small">
            <livewire:forget-password.forms />
        </div>
    </section>
@endsection

