@php
        $currentYear = date('Y');
@endphp

<footer class="footer">
    <livewire:lang-menu wire:key="ULM"/>
    <p class="text-light">&#169; SO 2023 - {{ $currentYear }}</p><a href="#"><img class="logo"
        src="{{ asset('img/logo.ico') }}" /></a>
</footer>
