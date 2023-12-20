
<div
role="dialog"
aria-labelledby="toast_label"
class="toast__container"
 id="defaultModal"
 wire:click="closeToast"
   x-data="{ isOpen: @entangle('isOpen') }"
     x-bind:class="{ 'open': isOpen }"
     x-on:open-toast.window="
        setTimeout(() => {
            isOpen = false;
        }, 10000);
     "
 >
 <h2 id="toast_label" class="sr-only" >toast info</h2>
 <div class="toast">{{$message}}</div>
</div>
