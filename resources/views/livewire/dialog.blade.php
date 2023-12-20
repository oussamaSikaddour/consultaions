<div
role="dialog"
 aria-labelledby="dialog_box"
 class="box"
 x-bind:class="{ 'open': {{ $isOpen ? 'true' : 'false' }} }"
 id="box" >
    <h3 id="dialog_box" class="sr-only">help about the box</h3>
      <div class="box__header">
        <h3 >{{ $question }}</h3>
      </div>
      <div class="box__body">
      {{ $details }}
      </div>
     <div class="box__footer">
      <button class="button box__closer" wire:click="closeDialog">Non</button>
      <button class="button button--primary" wire:click="confirmAction">Oui</button>
     </div>
</div>

