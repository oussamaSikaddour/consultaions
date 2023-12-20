@props(['items' => [], 'dropdownLink'])

<li class="nav__item nav__item--dropDown">
    <div id="subNav-btn" class="nav__btn nav__btn--dropdown" aria-expanded="false" aria-controls="subItems" aria-label="Show user menu" aria-labelledby="subNav-btn">
        {!! $dropdownLink !!}
    </div>
    <ul id="subItems" class="nav__items--sub" hidden>
        @foreach ($items as $item)
        <li>
            <a href="{{ $item['route'] }}">{{ $item['label'] }}</a>
        </li>
    @endforeach

    {{ $slot }}
    </ul>
</li>
