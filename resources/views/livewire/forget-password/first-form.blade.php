<!-- resources/views/livewire/registration-form.blade.php -->

<form class="form" wire:submit.prevent="handleSubmit" >
    <h3>Votre email doit être valide, un code de vérification vous sera envoyé</h3>
    <div>
        <x-input name="form.email" label="Email"  type="email" html_id="FFPEmail" />
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-loading />
        </div>
        <button type="submit" class="button button--primary">Valider</button>
    </div>
</form>
