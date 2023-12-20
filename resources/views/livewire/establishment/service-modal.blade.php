@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
    $specailtyOptionsdata = app('my_constants')['SPECIALTY_OPTIONS'];
@endphp

<div class="form__container">
    <form class="form" wire:submit.prevent="handleSubmit">

        <div>
            <x-input name="{{ $form }}.name" label="Nom du service" type="text" html_id="SFMName" />
            <x-input name="{{ $form }}.head_of_service" label="Chef de service" type="text" html_id="SFMHeadOfS" />
        </div>
        <div>



                <x-selector
                 htmlId="ms-specialty"
                 name="{{ $form }}.specialty"
                 label="spécialité :"
                 :data="$specailtyOptionsdata"
                 :showError="true"
                 />

        </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
    </form>
</div>
