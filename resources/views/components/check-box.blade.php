@props(['model','label','value','htmlId'])
<div class="check-box">
    <input  wire:model="{{$model}}" type="checkbox" value="{{ $value }}" id="{{ $htmlId }}"/>
    <label for="{{ $htmlId }}">{{ $label }}</label>
</div>
