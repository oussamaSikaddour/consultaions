<form class="form form--2" id="myForm"
>
    <h3>@lang("forms.register.second-f.instruction")</h3>
    <div>
        <x-input name="form.email"
        :label="__('forms.register.second-f.email')"
        type="email"
        html_id="registerSFEmail" />
        <x-input
        name="form.code"
       :label="__('forms.register.second-f.code')"
        type="text"
        html_id="registerVerificationCode" />
    </div>
    <div>
        <button class="button" wire:click.prevent='setNewValidationCode'>
            @lang("forms.register.second-f.new-code-btn")
        </button>
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-loading  />
       </div>
        <button class="button button--primary" type='submit' wire:click.prevent="handleSubmit" id="validerButton">
            @lang("forms.common.submit-btn")
        </button>
    </div>
</form>

@script
<script>
 const form = document.getElementById('myForm');
 const validerButton = document.getElementById('validerButton');
 form.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            // Prevent the default form submission
            event.preventDefault();
            // Trigger a click event on the "Valider" button
            validerButton.click();
        }
});
 document.addEventListener('email-registration-is-set', function(event) {
    @this.setEmail(event.detail.data.email);
 });
$wire.on("second-step-succeeded", () => {
 const registerFirstForm = document.querySelector(".form--1");
const registerSecondForm = document.querySelector(".form--2");
const registerForms = document.querySelector(".forms");
    registerForms.classList.remove("slide");
    localStorage.removeItem('registration-email');
    registerSecondForm.setAttribute("inert", "");
    registerFirstForm.removeAttribute("inert");
})
</script>
@endscript
