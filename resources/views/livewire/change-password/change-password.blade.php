<form class="form" wire:submit="handelSubmit" x-on:redirect-page="setTimeout(() => { $wire.redirectPage() }, 10000)">
    <h3 >Veuillez fournir les renseignements suivants:</h3>
    <div >
        <x-password-input label="Ancien mot de passe" name="form.password" html_id="CPPassword" />
        <x-password-input label="Nouveau mot de passe" name="form.newPassword" html_id="newPassword" />
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-loading />
        </div>
        <button type="submit" class="button button--primary">Valider</button>
    </div>
</form>
