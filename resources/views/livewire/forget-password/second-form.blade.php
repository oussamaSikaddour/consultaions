<form class="form" wire:submit.prevent="handleSubmit" >
    <h3>Votre email doit être valide, un code de vérification vous sera envoyé</h3>

    <div >
        <x-input name="form.email" label="Email"  type="email" html_id="FPEmail" />
        <x-input name="form.code" label="Verification Code"  type="test" html_id="FPPassword" />
    </div>
    <div >
        <x-password-input label=" Nouveau Mot de passe"  name="form.password" html_id="FPNPassword"/>
    </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
</form>
