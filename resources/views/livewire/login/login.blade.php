<form class="form" wire:submit="handelSubmit">
    <h3>
    Veuillez fournir les renseignements suivants :
    </h3>
    <div>
        <x-input name="form.email" label="email"  type="email" html_id="loginEmail" />
        <x-password-input name="form.password" label="Mot de passe"   html_id="loginPassword"/>
   </div>

   <div>
    <a href="{{ route("forgetPasswordPage") }}"> <p>Vous avez oublié votre mot de passe ?</p></a>

  </div>



   <div class="form__actions">

       <div wire:loading>
            <x-loading  />
       </div>
       <a class="button"    href="{{ route("registerPage") }}" >Créer un compte</a>
       <button type="submit" class="button button--primary">Valider</button>

   </div>


  </form>
