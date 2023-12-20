@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
    $specailtyOptionsdata = app('my_constants')['SPECIALTY_OPTIONS'];
    $minDate =now()->addDays(3)->toDateString();

@endphp

<div class="form__container">

    <form class="form" wire:submit.prevent="handleSubmit">


       @if (count($this->consultationsPlaces())===0 && count($this->doctors())===0)
       <div>
           <h3>vous ne pouvez pas ajouter de jour de planification pour le moment, vous devez ajouter au moins un médecin et un lieu de consultation</h3>
       </div>
      @elseif  (count($this->consultationsPlaces())===0)
      <div>
          <h3>vous ne pouvez pas ajouter de jour de planification pour le moment, vous devez ajouter au moins  un lieu de consultation</h3>
      </div>
      @elseif  ( count($this->doctors())===0)
      <div>
          <h3>vous ne pouvez pas ajouter de jour de planification pour le moment, vous devez ajouter au moins un médecin</h3>
      </div>

      @else
         @if($form==="addForm")
        <div>

            <x-selector
            htmlId="mpd-specialty"
             name="specialty"
             label="spécialité"
             :data="$specailtyOptionsdata"
             type="filter"
             />

             @if(count($this->doctors)!==0)
            <x-selector
            htmlId="mpd-doctor"
             name="{{ $form }}.doctor_id"
             label="médecin"
             :data="$doctorsOptions"
             :showError="true"
             />
             @endif
        </div>
        @endif
        <div>

            <x-selector
            htmlId="mpd-lc"
            name="{{ $form }}.consultation_place_id"
             label="Lieu de consultation"
             :data="$consultationPlaceOptions"
             :showError="true"
             />
             <x-input name="{{ $form }}.day_at"
             label="la date"
             type="date"
             html_id="pdDayAt"
             :min="$minDate"
              />
        </div>
        <div>
            <x-input name="{{ $form }}.number_of_consultation" label="Nombre maximum de rendez-vous" type="number" html_id="pdNoC"  min="0"/>
            {{-- <x-input name="{{ $form }}.number_of_rendez_vous" label="Nombre de rendez-vous confirmés" type="number" html_id="pdNoR" min="0" /> --}}
        </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
        @endif
    </form>
</div>
