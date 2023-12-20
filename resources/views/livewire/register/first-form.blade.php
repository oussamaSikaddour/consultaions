<!-- resources/views/livewire/registration-form.blade.php -->

<form class="form" wire:submit.prevent="handleSubmit" >
    <h3>Votre email doit être valide, un code de vérification vous sera envoyé</h3>
    <div>

        <x-input name="form.last_name" label="Nom"  type="text" html_id="registLastName"  />
        <x-input name="form.first_name" label="Prénom"  type="text" html_id="registFirstName"  />

    </div>
    <div>
        <x-input name="form.birth_date" label="Date de naissance"  type="date" html_id="registBrithDate"  />
        <x-input name="form.email" label="Email"  type="email" html_id="registEmail" />
    </div>
    <div>
         <x-input name="form.tel" label="tel"  type="text" html_id="registTel" />
         <x-password-input name="form.password" label="Mot de passe"   html_id="registPassword"/>
    </div>
    <div class="form__actions">

        <div wire:loading>
             <x-loading  />
        </div>
        <a class="button"    href="{{ route("loginPage") }}" >J'ai déja un compte</a>
         <button type="submit" class="button button--primary">Valider</button>
    </div>
</form>
