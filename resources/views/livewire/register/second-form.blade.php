<form class="form" id="myForm">
    <h3>Vous devez entrer le code de vérification envoyé à votre adresse e-mail</h3>
    <div>
        <x-input name="form.email" label="Email" type="email" html_id="registerSFEmail" />
        <x-input name="form.code" label="Verification Code" type="text" html_id="registerVerificationCode" />
    </div>
    <div>
        <button class="button" wire:click.prevent='setNewValidationCode'>
            Obtenir un nouveau code de vérification
        </button>
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-loading  />
       </div>
        <button class="button button--primary" type='submit' wire:click.prevent="handleSubmit" id="validerButton">
            Valider
        </button>
    </div>
</form>

<script>
    const form = document.getElementById('myForm');
    const validerButton = document.getElementById('validerButton');

    // Add a keydown event listener to the form
    form.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            // Prevent the default form submission
            event.preventDefault();

            // Trigger a click event on the "Valider" button
            validerButton.click();
        }
    });
</script>
