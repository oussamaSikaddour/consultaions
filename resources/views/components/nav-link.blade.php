@props(['route', 'label','parameter'=>null])

@php
    $isActive = Route::is($route) ? 'active' : '';
@endphp

<li class="nav__item {{ $isActive }}">
    <a class="nav__link"
    aria-current="{{$label }}"
    @if($parameter)
    href="{{ route($route,$parameter) }}"
    @else
    href="{{ route($route) }}"
    @endif

    >
    {{ $label }}
    </a>
</li>
