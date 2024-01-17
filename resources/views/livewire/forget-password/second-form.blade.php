<form class="form form--2" wire:submit.prevent="handleSubmit" >
    <h3>      @lang("forms.forget-pwd.second-f.instruction")</h3>

    <div >
        <x-input
        name="form.email"
        :label="__('forms.forget-pwd.second-f.email')"
        type="email"
        html_id="FPEmail" />
        <x-input
        name="form.code"
       :label="__('forms.forget-pwd.second-f.code')"
          type="text"
          html_id="FPPassword" />
    </div>
    <div >
        <x-password-input
        :label="__('forms.forget-pwd.second-f.password')"
          name="form.password"
          html_id="FPNPassword"/>
    </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button
              type="submit" class="button button--primary">
                @lang("forms.common.submit-btn")</button>
        </div>
</form>


@script
<script>

document.addEventListener('email-forget-password-is-set', function(event) {
    @this.setEmail(event.detail.data.email);
 });

$wire.on("second-step-succeeded", () => {
const forgetPasswordForms = document.querySelector(".forms");
const forgetPasswordFirstForm = document.querySelector(".form--1");
const forgetPasswordSecondForm= document.querySelector(".form--2");
   forgetPasswordForms.classList.remove("slide");
    forgetPasswordSecondForm.setAttribute("inert", "");
    forgetPasswordFirstForm.removeAttribute("inert");
})
</script>
@endscript
