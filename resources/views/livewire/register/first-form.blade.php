<!-- resources/views/livewire/registration-form.blade.php -->

<form class="form form--1" wire:submit.prevent="handleSubmit" >
    <h3>@lang("forms.register.first-f.instruction")</h3>
    <div>

        <x-input
        name="form.last_name"
       :label="__('forms.register.first-f.l-name')"
        type="text"
         html_id="registLastName"  />
        <x-input
        name="form.first_name"
        :label="__('forms.register.first-f.f-name')"
        type="text"
        html_id="registFirstName"  />

    </div>
    <div>
        <x-input
        name="form.birth_date"
        :label="__('forms.register.first-f.b-date')"
         type="date"
         html_id="registBrithDate"  />
        <x-input
        name="form.email"
       :label="__('forms.register.first-f.email')"
        type="email"
        html_id="registEmail" />
    </div>
    <div>
         <x-input
          name="form.tel"
          :label="__('forms.register.first-f.tel')"
          type="text"
          html_id="registTel" />
         <x-password-input
         name="form.password"
         :label="__('forms.register.first-f.password')"
          html_id="registPassword"/>
    </div>
    <div class="form__actions">

        <div wire:loading>
             <x-loading  />
        </div>
        <a class="button"    href="{{ route("loginPage") }}" >@lang("forms.register.first-f.login-link")</a>
         <button type="submit" class="button button--primary">@lang("forms.common.submit-btn")</button>
    </div>
</form>


@script
<script>
 const registerFirstForm = document.querySelector(".form--1");
const registerSecondForm = document.querySelector(".form--2");
const registrationEmail = localStorage.getItem('registration-email') ;
const registerForms = document.querySelector(".forms");
if(registrationEmail){
    addEventListener("DOMContentLoaded", (event) => {
        despatchCustomEvent('email-registration-is-set',{email:registrationEmail});
    });
    registerForms.classList.add("slide");
    registerFirstForm.setAttribute("inert", "");
    registerSecondForm.removeAttribute("inert");
} else {
    registerForms.classList.remove("slide");
    registerFirstForm.removeAttribute("inert");
    registerSecondForm.setAttribute("inert", "");
}

$wire.on("first-step-succeeded", () => {
    registerForms.classList.add("slide");
    localStorage.setItem('registration-email', @this.registrationEmail);
    despatchCustomEvent('email-registration-is-set', {email: @this.registrationEmail});
    registerFirstForm.setAttribute("inert", "");
    registerSecondForm.removeAttribute("inert");
    setTimeout(() => {
    focusNonHiddenInput(registerSecondForm);
}, 500);
})

$wire.on('form-submitted',()=>{
        clearErrorsOnFocus()
})
</script>
@endscript
