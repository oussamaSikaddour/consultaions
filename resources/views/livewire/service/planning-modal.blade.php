@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
    $monthsOptions = app('my_constants')['MONTHS_OPTIONS'][app()->getLocale()];
    $yearsOptions = app('my_constants')['YEARS'];
    $stateOptions= app('my_constants')['PLANNING_STATE'][app()->getLocale()];

@endphp

<div class="form__container">
    <form class="form" wire:submit.prevent="handleSubmit">

       <div>
        <x-input
        name="{{ $form }}.name"
        :label="__('modals.planning.name')"
        type="text"
        html_id="pfName" />
        @if($id!=="")
        <x-selector
        htmlId="mp-state"
         name="{{ $form }}.state"
         :label="__('modals.planning.state')"
         :data="$stateOptions"
         />
       @endif
    </div>
    <div>

            <x-selector
            htmlId="mp-year"
             name="{{ $form }}.year"
             :label="__('modals.planning.year')"
             :data="$yearsOptions"
             :showError="true"
             />

            <x-selector
            htmlId="mp-month"
             name="{{ $form }}.month"
             :label="__('modals.planning.month')"
             :data="$monthsOptions"
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
