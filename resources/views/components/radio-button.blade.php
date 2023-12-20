@props(['model','htmlId','value','label'=>'','type'=>"", "event"=>""])


<div class="radio__button" {{ $attributes }}>

    <input type="radio" id="{{ $htmlId }}"
    @if($type="forTable")
    x-on:click="$dispatch('{{ $event }}', {selectedValue: $event.target.value })"
    @endif
    wire:model="{{$model}}"

    value="{{ $value }}"/>
 <label for="{{ $htmlId }}" >{{ $label }}</label>
</div>


