@php
    $specialtyOptionsData = app('my_constants')['SPECIALTY_OPTIONS'];
    $dairasOptionsData = app('my_constants')['DAIRAS'];
@endphp
<div class="form__container">
<form class="form" wire:submit.prevent="handleSubmit">

        <h2>Pour afficher la liste des rendez-vous disponibles :</h2>
        <h3>1. Choisissez une spécialité médicale.</h3>
        <h3>2. sélectionner au moins une daïra et un lieu de consultation</h3>
        <h3>3. Sélectionnez au moins un médecin.</h3>




        <div>
            <x-selector
                htmlId="rd-specialty"
                name="form.specialty"
                label="spécialité"
                :data="$specialtyOptionsData"
                type="filter"
            />
        </div>
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
                type="filter"
                showError="true"
            />
        </div>

         <div>
            <x-selector
            htmlId="rd-doctor"
            name="form.doctor_id"
            label="médecin"
            :data="$doctorsOptions"
            type="filter"
        />
        </div>

        <div><h3>Vous pouvez changer la période comme vous convient :</h3></div>
        <div>
            <x-input
                name="dateMin"
                label="Date début"
                type="date"
                html_id="pdDateMin"
                :min="$dateMin"
                role="filter"
            />
            <x-input
                name="dateMax"
                label="Date Fin"
                type="date"
                html_id="pdDateMax"
                :max="$dateMax"
                role="filter"
            />
        </div>
         @if(count($planningDaysOptions) >1)
              <h3>Veuillez noter que la lettre d'orientation est requise en format photo</h3>
               <div>
                     <x-selector
                       htmlId="rd-planningDay"
                       name="form.planning_day_id"
                       label="date de rendez-vous :"
                       :data="$planningDaysOptions"
                      :showError="true"
                   />
                <x-upload-input model="form.referral_letter" label="La lettre d'orientation."/>
              </div>
              @if ($temporaryImageUrl)
               <div>
                <div class="imgs__container">
                  <h2>La lettre d'orientation</h2>
                   <div class="imgs">
                     <img class="img" src="{{ $temporaryImageUrl}}"
                       alt="La lettre d'orientation.">
                    </div>
                  </div>
                </div>
              @endif
         @elseif ($this->form->consultation_place_id && $this->form->doctor_id !=null)
         <div>
            <h3>il n'y a pas de rendez-vous disponible pour le moment</h3>
         </div>
         @endIf
         @if(!$youHaveAlreadyAnUpcomingRendezVous)
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">Valider</button>
        </div>
        @endif
    </form>
</div>
