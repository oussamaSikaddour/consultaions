<button class="button {{ $classes }} box__opener" wire:click="openDialog">
    {{ $title }}
      {!! $content !!}
</button>


@script
<script>
$wire.on("open-dialog",()=>{
const boxOpener = document.querySelector(".box__opener");
const boxCloser = document.querySelector(".box__closer");
const dialog = document.querySelector(".box");
dialog.classList.add("open");
const isOpen = dialog.classList.contains("open");
setAriaAttributes(!isOpen, isOpen ? "0" : "-1",dialog);
toggleInertForAllExceptOpenedElement(dialog,"open")
boxCloser.focus(); // Focus on the close button when the dialog opens
const closedialog = () => {
dialog.classList.remove("open");
const isOpen = dialog.classList.contains("open");
setAriaAttributes(!isOpen, isOpen ? "0" : "-1",dialog);
despatchCustomEvent('dialog-will-be-close');
toggleInertForAllExceptOpenedElement(dialog,"open")
 };
 boxCloser.addEventListener("click", closedialog);
})
</script>
@endscript
