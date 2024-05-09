@php
$dialogQuestion = [
    "user" => function ($attribute) {
        return __('dialogs.delete.user', ['attribute' => $attribute]);
    },
    "establishment" => function ($attribute) {
        return __('dialogs.delete.establishment', ['attribute' => $attribute]);
    },
    "service" => function ($attribute) {
        return __('dialogs.delete.service', ['attribute' => $attribute]);
    },
    "c-place" => function ($attribute) {
        return __('dialogs.delete.c-place', ['attribute' => $attribute]);
    },
    "planning" => function ($attribute) {
        return __('dialogs.delete.planning', ['attribute' => $attribute]);
    },
    "planning-day" => function ($attribute) {
        return __('dialogs.delete.planning-day', ['attribute' => $attribute]);
    },
    "m-file" => function ($attribute) {
        return __('dialogs.delete.m-file', ['attribute' => $attribute]);
    },
    "rendez-vous" => function ($attribute) {
        return __('dialogs.delete.rendez-vous', ['attribute' => $attribute]);
    },
];
@endphp

<div role="dialog"
    aria-labelledby="dialog_box"
    class="box"
    x-bind:class="{ 'open': {{ $isOpen ? 'true' : 'false' }} }"
    id="box">
    <h3 id="dialog_box" class="sr-only">help about the box</h3>
    <div class="box__header">
        <h3>{{ __($question) }}</h3>
    </div>
    <div class="box__body">
        @if (count($details) === 2 && array_key_exists($details[0], $dialogQuestion))
            {{ $dialogQuestion[$details[0]]($details[1]) }}
        @else
            {{ '' }}
        @endif
    </div>
    <div class="box__footer">
        <button class="button box__closer" wire:click="closeDialog">Non</button>
        <button class="button button--primary box__confirmation" wire:click="confirmAction">Oui</button>
    </div>
</div>

@script
    <script>
        document.addEventListener('dialog-will-be-close', function(event) {
            @this.closeDialog();
        });

        $wire.on("user-chose-yes",()=>{
            @this.closeDialog();
            const dialog = document.querySelector(".box");
            dialog.classList.remove("open");
            const isOpen = dialog.classList.contains("open");
           setAriaAttributes(!isOpen, isOpen ? "0" : "-1",dialog);
            toggleInertForAllExceptOpenedElement(dialog,"open")
        })
    </script>
@endscript
