@extends('layouts.guestLayout')

@section('pageContent')
    <section class="section">
        <h2>@lang('pages.register.main-title')</h2>
        <div class="form__container small">
            <livewire:register.register-forms />
        </div>
    </section>
@endsection
