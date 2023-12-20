@php

    $dairasOptionsData = app('my_constants')['DAIRAS'];
    $minDateForDateMin = now()->addDays(15)->toDateString(); // Set the minimum date for DateMin


@endphp

<div class="form__container">
<form class="form" wire:submit.prevent="handleSubmit">
        <div>
            <x-selector
            htmlId="mcpd-diara"
            name="daira"
            label="Daïra :"
            :data="$dairasOptionsData"
            type="filter"
            />
            <x-selector
                htmlId="rd-lc"
                name="form.consultation_place_id"
                label="Lieu de consultation"
                :data="$consultationPlaceOptions"
                showError="true"
            />
        </div>

         <div>
            <x-input
                name="form.day_at"
                label="La Date du :"
                type="date"
                html_id="pdDateMin"
                :min="$minDateForDateMin"
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
