@extends('layouts.guestLayout')

@section('pageContent')
    <section class="section">
        <h2>@lang("pages.site-params.main-title")</h2>
        <div class="form__container small">
            <livewire:admin.site-parameters.forms />
        </div>
    </section>
@endsection
