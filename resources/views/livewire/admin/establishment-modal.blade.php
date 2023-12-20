@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
@endphp

<div class="form__container">
    <form class="form" wire:submit.prevent="handleSubmit">
        <div>
            <x-input name="{{ $form }}.acronym" label="abréviation du nom" type="text" html_id="EFAcronym" />
            <x-input name="{{ $form }}.name" label="Nom" type="text" html_id="EFName" />
        </div>
        <div>
            <x-input name="{{ $form }}.email" label="email" type="email" html_id="EFEmail" />
            <x-input name="{{ $form }}.address" label="l'adresse" type="text" html_id="EFAdresseq" />
        </div>
        <div>
            <x-input name="{{ $form }}.tel" label="téléphone fixe" type="text" html_id="EFTel" />
            <x-input name="{{ $form }}.fax" label="numéro du fax" type="text" html_id="EFFax" />
        </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
    </form>
</div>
