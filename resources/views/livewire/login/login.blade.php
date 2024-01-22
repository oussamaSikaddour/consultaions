<form class="form" wire:submit="handelSubmit">
    <h3>
    @lang("forms.login.instruction")
    </h3>
    <div>
        <x-input
        name="form.email"
        :label="__('forms.login.email')"
        type="email"
        html_id="loginEmail" />
        <x-password-input
        name="form.password"
       :label="__('forms.login.password')"
        html_id="loginPassword"/>
   </div>

   <div>
    <a href="{{ route("forgetPasswordPage") }}">
        <p>@lang("forms.login.forget-password-link")</p></a>

  </div>



   <div class="form__actions">

       <div wire:loading>
            <x-loading  />
       </div>
       <a class="button"    href="{{ route("registerPage") }}" >
        @lang("forms.login.forget-password-link")</a>
       <button type="submit" class="button button--primary">@lang("forms.common.submit-btn")</button>

   </div>


  </form>



  @script
  <script>
      $wire.on('form-submitted',()=>{
        clearErrorsOnFocus()
         })
  </script>
  @endscript
