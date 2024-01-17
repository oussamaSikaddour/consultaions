@extends('layouts.guestLayout')
@section('pageContent')
<section class="section">
    <h2>@lang('pages.login.main-title')</h2>
    <div class="form__container small ">
<livewire:login.login />
    </div>
</section>
@endsection


