@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
    $dairasOptionsData = app('my_constants')['DAIRAS'];
@endphp

<div class="form__container">
    <form class="form" wire:submit.prevent="handleSubmit">

        <div>
            <x-input name="{{ $form }}.name" label="lieu de consultation" type="text" html_id="ACPName" />

            <x-selector
             htmlId="mcp-diara"
             name="{{ $form }}.daira"
             label="Daïra :"
             :data="$dairasOptionsData"
             :showError="true"
             />

        </div>
        <div>
            <x-input name="{{ $form }}.address" label="l'adresse" type="text" html_id="ACPAddress" />
        </div>
        <div>
            <x-input name="{{ $form }}.tel" label="numéro de téléphone" type="text" html_id="ACPPhone" />
            <x-input name="{{ $form }}.fax" label="numéro de fax" type="text" html_id="ACPFax" />
        </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
    </form>
</div>
