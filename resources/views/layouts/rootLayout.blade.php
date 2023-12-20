<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title)? $title .' |': '' }}  {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
    @if(isset($customCSS) && $customCSS)
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> <!-- Your custom CSS link -->
    @else
        <link href="{{ asset('css/index.css') }}" rel="stylesheet"> <!-- Default CSS link -->
    @endif
</head>
<body>
    <livewire:toast />
    <livewire:errors />
    <livewire:modal />
    <livewire:dialog/>
    @yield("content")

    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
