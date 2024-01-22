@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
    $specailtyOptionsdata = app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()];
    $minDate =now()->addDays(3)->toDateString();
@endphp
<div class="form__container">

    <form class="form" wire:submit.prevent="handleSubmit">

         @if($form==="addForm")
        <div>

            <x-selector
            htmlId="mpd-specialty"
             name="specialty"
             :label="__('modals.planning-day.specialty')"
             :data="$specailtyOptionsdata"
             type="filter"
             />


            <x-selector
            htmlId="mpd-doctor"
             name="{{ $form }}.doctor_id"
            :label="__('modals.planning-day.doctor')"
             :data="$doctorsOptions"
             :showError="true"
             type="filter"
             />

        </div>
        @endif
        <div>

            <x-selector
            htmlId="mpd-lc"
            name="{{ $form }}.consultation_place_id"
             :label="__('modals.planning-day.c-place')"
             :data="$consultationPlaceOptions"
             :showError="true"
             />
             <x-input name="{{ $form }}.day_at"
            :label="__('modals.planning-day.date')"
             type="date"
             html_id="pdDayAt"
             :min="$minDate"
              />
        </div>
        <div>
            <x-input
             name="{{ $form }}.number_of_consultation"
            :label="__('modals.planning-day.c-number')"
             type="number"
             html_id="pdNoC"
              min="0"/>
            {{-- <x-input name="{{ $form }}.number_of_rendez_vous" label="Nombre de rendez-vous confirmés" type="number" html_id="pdNoR" min="0" /> --}}
        </div>

          @if( $form ==="addForm")
             @if (count($this->consultationsPlaces())===0 && count($this->doctors())===0)
                <div>
                   <h3>
                   @lang("modals.planning-day.doctor-c-place-err")
                 </h3>
               </div>
             @elseif (count($this->consultationsPlaces())===0)
              <div>
                  <h3>  @lang("modals.planning-day.c-place-err")</h3>
              </div>
             @elseif  ( count($this->doctors())===0)
              <div>
               <h3>@lang("modals.planning-day.doctor-err")</h3>
              </div>
            @else
            <div class="form__actions">
                <div wire:loading>
                    <x-loading />
                </div>
                <button type="submit" class="button button--primary">
               @lang("modals.common.submit-btn")
                </button>
            </div>
            @endif
      @else
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">
           @lang("modals.common.submit-btn")
            </button>
        </div>
    @endif

    </form>
</div>


@script
<script>
$wire.on('form-submitted',()=>{
clearErrorsOnFocus()
})
</script>
 @endscript
