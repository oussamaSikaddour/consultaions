
<div
role="alert"
aria-labelledby="errors_label"
class="errors__container"
id="defaultErrors"
x-bind:class="{ 'open': {{ $isOpen ? 'true' : 'false' }} }"
>
 <h2 id="errors_label " class="sr-only" >errors</h2>
    <button
    class="errors__closer"
    wire:click="toggleErrors()">
      <span ><i class="fa-solid fa-xmark"></i></span>
    </button>
     <ul class="errors" tabindex="0">
        @foreach ($errors as $error)
        <x-error :error="$error"/>
         @endforeach
    </ul>
</div>





@script
<script>
    $wire.on('handle-errors-state', () => {
          const errors = document.querySelector(".errors__container");
          if (@this.isOpen) {
                errors.classList.add("open");
                const closeErrors = document.querySelector(".errors__closer");
                closeErrors.focus();
            } else {
                errors.classList.remove("open");
            }
            const isOpen = errors.classList.contains("open");
            setAriaAttributes(!isOpen, isOpen ? "0" : "-1", errors);
            toggleInertForAllExceptOpenedElement(errors, "open");
    });
</script>
@endscript
