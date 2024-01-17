
<div
tabindex="0"
role="dialog"
aria-labelledby="toast_label"
class="toast__container"
 id="defaultModal"
 x-bind:class="{ 'open': isOpen }"
x-data="{ isOpen: @entangle('isOpen') }"
 >
 <h2 id="toast_label" class="sr-only" >toast info</h2>
 <div class="toast">{{$message}}</div>
</div>

@script
<script>
$wire.on('handle-toast-state', () => {
    const toast = document.querySelector(".toast__container");
    let toastTimeout; // Declare the timeout variable outside the if block
    if (@this.isOpen) {
        toast.classList.add("open");
        toast.focus();
        clearTimeout(toastTimeout); // Clear any existing timeout
        toastTimeout = setTimeout(() => {
            toast.classList.remove("open");
            @this.toggleToast();
        }, 3000);
    } else {
        clearTimeout(toastTimeout);
        toast.classList.remove("open");
    }
    toast.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === "Space") {
            e.stopPropagation();
            toast.classList.remove("open");
            @this.toggleToast();
            clearTimeout(toastTimeout);
        }
    });
    toast.addEventListener("click", (e) => {
           e.stopPropagation();
            toast.classList.remove("open");
            @this.toggleToast();
            clearTimeout(toastTimeout);
    });
    const isOpen = toast.classList.contains("open");
    setAriaAttributes(!isOpen, isOpen ? "0" : "-1", toast);
});
</script>
@endscript

