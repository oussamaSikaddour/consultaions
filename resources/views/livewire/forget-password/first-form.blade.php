<!-- resources/views/livewire/registration-form.blade.php -->

<form class="form form--1" wire:submit.prevent="handleSubmit" >
    <h3>
        @lang("forms.forget-pwd.first-f.instruction")
    </h3>
    <div>
        <x-input
        name="form.email"
        :label="__('forms.forget-pwd.first-f.email')"
          type="email"
           html_id="FFPEmail" />
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-loading />
        </div>
        <button type="submit" class="button button--primary">@lang("forms.common.submit-btn")</button>
    </div>
</form>



@script
<script>
 const forgetPasswordFirstForm = document.querySelector(".form--1");
const forgetPasswordSecondForm = document.querySelector(".form--2");
const forgetPasswordForms = document.querySelector(".forms");
    forgetPasswordForms.classList.remove("slide");
    forgetPasswordFirstForm.removeAttribute("inert");
    forgetPasswordSecondForm.setAttribute("inert", "");
$wire.on("first-step-succeeded", () => {
    forgetPasswordForms.classList.add("slide");
    despatchCustomEvent('email-forget-password-is-set', {email: @this.forgetPasswordEmail});
    forgetPasswordFirstForm.setAttribute("inert", "");
    forgetPasswordSecondForm.removeAttribute("inert");
    setTimeout(() => {
    focusNonHiddenInput(forgetPasswordSecondForm);
}, 500);
})
</script>
@endscript
