@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
@endphp

<div class="form__container">
    <form class="form" wire:submit.prevent="handleSubmit">
        <div>
            <x-input
            name="{{ $form }}.acronym"
            :label="__('modals.establishment.acronym')"
            type="text"
            html_id="EFAcronym" />
            <x-input
            name="{{ $form }}.name"
            :label="__('modals.establishment.name')"
            type="text"
            html_id="EFName" />
        </div>
        <div>
            <x-input
            name="{{ $form }}.email"
            label="email"
            :label="__('modals.establishment.email')"
            type="email"
            html_id="EFEmail" />
            <x-input
             name="{{ $form }}.address"
             label="l'adresse"
             type="text"
             html_id="EFAdresseq" />
        </div>
        <div>
            <x-input
            name="{{ $form }}.tel"
            :label="__('modals.establishment.land-line-number')"
             type="text"
             html_id="EFTel" />
            <x-input
            name="{{ $form }}.fax"
            :label="__('modals.establishment.fax-number')"
            type="text"
            html_id="EFFax" />
        </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">@lang('modals.common.submit-btn')</button>
        </div>
    </form>
</div>
