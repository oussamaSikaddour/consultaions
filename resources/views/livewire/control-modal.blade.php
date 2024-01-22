@php

    $dairasOptionsData = app('my_constants')['DAIRAS'][app()->getLocale()];
    $minDateForDateMin = now()->addDays(15)->toDateString(); // Set the minimum date for DateMin


@endphp

<div class="form__container">
<form class="form" wire:submit.prevent="handleSubmit">
        <div>
            <x-selector
            htmlId="mcpd-diara"
            name="daira"
            :label="__('modals.rendez-vous.daira')"
            :data="$dairasOptionsData"
            type="filter"
            />
            <x-selector
                htmlId="rd-lc"
                name="form.consultation_place_id"
                :label="__('modals.rendez-vous.c-place')"
                :data="$consultationPlaceOptions"
                showError="true"
            />
        </div>

         <div>
            <x-input
                name="form.day_at"
                :label="__('modals.rendez-vous.date')"
                type="date"
                html_id="pdDateMin"
                :min="$minDateForDateMin"
            />
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
