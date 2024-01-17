
<button class="button {{ $classes }} modal__opener" wire:click="openModal">
{{ $title }}
  {!! $content !!}
</button>


@script
<script>
$wire.on("open-modal",()=>{

const openModalBtn = document.querySelector(".modal__opener");
const closeModalBtn = document.querySelector(".modal__closer");
const modal = document.querySelector(".modal");
modal.classList.add("open");
const isOpen = modal.classList.contains("open");
setAriaAttributes(!isOpen, isOpen ? "0" : "-1",modal);
toggleInertForAllExceptOpenedElement(modal,"open")
setTimeout(() => {
const modalForm = modal.querySelector(".form")
focusNonHiddenInput(modalForm);
}, 500);

 const closeModal = () => {
modal.classList.remove("open");
const isOpen = modal.classList.contains("open");
setAriaAttributes(!isOpen, isOpen ? "0" : "-1",modal);
despatchCustomEvent('model-will-be-close');
toggleInertForAllExceptOpenedElement(modal,"open")
openModalBtn.focus();
 };
 closeModalBtn.addEventListener("click", closeModal);
})
</script>
@endscript
