@php
    $specialtyOptionsData = app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()];
    $dairasOptionsData = app('my_constants')['DAIRAS'][app()->getLocale()];
@endphp
<div class="form__container">
<form class="form" wire:submit.prevent="handleSubmit">

    @if ( $this->form->specialty !=""
          && $this->daira !=""
          && $this->form->consultation_place_id !=""
          &&   count($this->doctors()) === 0)
    <h2 >@lang('modals.rendez-vous.no-c-place-or-no-doctor').</h2>

    @elseif (
    count(
        $this->planningDays()) === 0 &&
         $this->form->doctor_id)
    <div>
       <h2>@lang("modals.rendez-vous.not-found")</h2>
    </div>
   @else
        <h2>@lang('modals.rendez-vous.intro') :</h2>
        <h3>1. @lang('modals.rendez-vous.first-instruction').</h3>
        <h3>2. @lang('modals.rendez-vous.second-instruction')</h3>
        <h3>3. @lang('modals.rendez-vous.third-instruction')</h3>
    @endif
        <div>
            <x-selector
                htmlId="rd-specialty"
                name="form.specialty"
               :label="__('modals.rendez-vous.specialty')"
                :data="$specialtyOptionsData"
                type="filter"
            />
        </div>
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
                type="filter"
                showError="true"
            />
        </div>

         <div>
            <x-selector
            htmlId="rd-doctor"
            name="form.doctor_id"
            :label="__('modals.rendez-vous.doctor')"
            :data="$doctorsOptions"
            type="filter"
        />
        </div>

        <div><h3>@lang('modals.rendez-vous.fourth-instruction')</h3></div>
        <div>
            <x-input
                name="dateMin"
                :label="__('modals.rendez-vous.start-d')"
                type="date"
                html_id="pdDateMin"
                :min="$dateMin"
                role="filter"
            />
            <x-input
                name="dateMax"
                :label="__('modals.rendez-vous.end-d')"
                type="date"
                html_id="pdDateMax"
                :max="$dateMax"
                role="filter"
            />
        </div>
         @if(count($this->planningDays())>0)
              <h3>@lang('modals.rendez-vous.fifth-instruction')</h3>
               <div>
                     <x-selector
                       htmlId="rd-planningDay"
                       name="form.planning_day_id"
                       :label="__('modals.rendez-vous.date')"
                       :data="$planningDaysOptions"
                      :showError="true"
                   />
                <x-upload-input
                model="form.referral_letter"
               :label="__('modals.rendez-vous.letter')"
                />
              </div>
              @if ($temporaryImageUrl)
               <div>
                <div class="imgs__container">
                  <h2>@lang('modals.rendez-vous.letter') :</h2>
                   <div class="imgs">
                     <img class="img" src="{{ $temporaryImageUrl}}"
                       alt=@lang('modals.rendez-vous.letter')>
                    </div>
                  </div>
                </div>
              @endif
         @endif
         @if(!$youHaveAlreadyAnUpcomingRendezVous && count($this->doctors()) > 0 && count($this->planningDays()) > 0)

            <div class="form__actions">
               <div wire:loading>
                <x-loading />
                 </div>
                 <button type="submit" class="button button--primary">@lang("modals.common.submit-btn")</button>
              </div>
        @endif


    </form>
</div>
