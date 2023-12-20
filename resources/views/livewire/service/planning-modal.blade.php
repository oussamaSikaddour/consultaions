@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
    $monthsOptions = app('my_constants')['MONTHS_OPTIONS'];
    $yearsOptions = app('my_constants')['YEARS'];
    $stateOptions= app('my_constants')['PLANNING_STATE']

@endphp

<div class="form__container">
    <form class="form" wire:submit.prevent="handleSubmit">

       <div>
        <x-input name="{{ $form }}.name" label="Nom Du Planning" type="text" html_id="pfName" />
        @if($id!=="")
        <x-selector
        htmlId="mp-state"
         name="{{ $form }}.state"
         label="état"
         :data="$stateOptions"
         />
       @endif
    </div>
    <div>

            <x-selector
            htmlId="mp-year"
             name="{{ $form }}.year"
             label="Année"
             :data="$yearsOptions"
             :showError="true"
             />

            <x-selector
            htmlId="mp-month"
             name="{{ $form }}.month"
             label="Mois"
             :data="$monthsOptions"
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
