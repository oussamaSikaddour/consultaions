<div class="check-box" id="checkbox-container">
    <input
      wire:model="{{$model}}"
      wire:key="{{$model}}"
      type="checkbox"
      value="{{ $value }}"
      id="{{ $htmlId }}"
      role="checkbox"
      aria-checked="false"
    />
    <label for="{{ $htmlId }}" tabindex="0"
           wire:target="{{$model}}">
      {{ $label }}
    </label>
  </div>
