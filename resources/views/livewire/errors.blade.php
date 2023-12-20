
<div
role="dialog"
aria-labelledby="errors_label"
class="errors__container"
 id="defaultErrors"
 x-bind:class="{ 'open': {{ $isOpen ? 'true' : 'false' }} }"
 >
 <h2 id="errors_label " class="sr-only" >errors</h2>
    <div class="errors__closer"  wire:click="closeErrors">
      <span ><i class="fa-solid fa-xmark"></i></span>
    </div>
     <ul class="errors">
        @foreach ($errors as $error)
        <x-error :error="$error"/>
         @endforeach
    </ul>
</div>
