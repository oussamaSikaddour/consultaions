@props(['name','htmlId','label', 'data', 'type' => '','showError'=>false])
<div class="select__group">
    <div>
      <label for="{{ $htmlId }}">{{ $label }}</label>
      <div class="select" >
        <select
        id="{{ $htmlId }}"
        @if ($type == 'filter')
        wire:model.live="{{ $name }}"
         @else
         wire:model="{{ $name }}"
        @endif>
            @foreach ($data as [$value, $option])
                <option value="{{ $value }}">{{ $option }}</option>
            @endforeach
        </select>
      </div>
    </div>

    @if ($showError)
    @error($name)
    <div class="input__error">{{ $message }}</div>
    @enderror
     @endif
    </div>

