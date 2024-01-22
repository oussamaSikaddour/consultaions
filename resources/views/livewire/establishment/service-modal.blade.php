@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
    $specailtyOptionsdata = app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()];
@endphp

<div class="form__container">
    <form class="form" wire:submit.prevent="handleSubmit">

        <div>
            <x-input
            name="{{ $form }}.name"
           :label="__('modals.service.name')"
            type="text"
            html_id="SFMName" />
            <x-input
             name="{{ $form }}.head_of_service"
             :label="__('modals.service.head-service')"
             type="text"
             html_id="SFMHeadOfS" />
        </div>
        <div>



                <x-selector
                 htmlId="ms-specialty"
                 name="{{ $form }}.specialty"
               :label="__('modals.service.specialty')"
                 :data="$specailtyOptionsdata"
                 :showError="true"
                 />

        </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button
                 type="submit"
                 class="button button--primary">
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
