@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
    $dairasOptionsData = app('my_constants')['DAIRAS'][app()->getLocale()];
@endphp

<div class="form__container">
    <form class="form" wire:submit.prevent="handleSubmit">

        <div>
            <x-input
            name="{{ $form }}.name"
           :label="__('modals.c-place.name')"
            type="text"
            html_id="ACPName" />

            <x-selector
             htmlId="mcp-diara"
             name="{{ $form }}.daira"
            :label="__('modals.c-place.daira')"
             :data="$dairasOptionsData"
             :showError="true"
             />

        </div>
        <div>
            <x-input
            name="{{ $form }}.address"
            :label="__('modals.c-place.address')"
            type="text"
            html_id="ACPAddress" />
        </div>
        <div>
            <x-input
            name="{{ $form }}.latitude"
            :label="__('modals.c-place.latitude')"
            type="text"
            html_id="AClatitude" />
            <x-input
            name="{{ $form }}.longitude"
            :label="__('modals.c-place.longitude')"
            type="text"
            html_id="AClongitude" />
        </div>
        <div>
            <x-input
            name="{{ $form }}.tel"
            :label="__('modals.c-place.land-line-number')"
            type="text"
             html_id="ACPPhone" />
            <x-input
            name="{{ $form }}.fax"
            :label="__('modals.c-place.fax-number')"
             type="text"
              html_id="ACPFax" />
        </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">
                @lang("modals.common.submit-btn")
            </button>
        </div>
    </form>
</div>


@script
<script>

$wire.on('form-submitted',()=>{
       clearErrorsOnFocus()
        })
</script>

@endscript
