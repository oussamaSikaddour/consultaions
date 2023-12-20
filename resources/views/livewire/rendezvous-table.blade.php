@php




@endphp
<div class="table__container"
 x-on:update-rendez-vous-table.window="$wire.$refresh()"
 >
    <div class="table__header">
        <div>
            @if($showMoreDetails)
            <button class="button button--primary rounded table__button"  wire:click="generateExcel">
                <i class="fa-solid fa-file-excel"></i></button>
            @endif
        </div>
        @if($showMoreDetails)
        <div>
            <x-input
               name="code"
              label="code dossier"
              type="text"
              html_id="codeRT"
              role="filter"/>

              <x-input
              name="dayAt"
              label="la date"
              type="date"
              html_id="pdDayAt"
              role="filter"
          />
        </div>
        <div>
            <x-input
            name="patient"
            label="Nom Patient"
             type="text"
             html_id="patientRT"
             role="filter"/>
            <x-input
            name="birthDate"
             label="date de naissance"
             type="date"
             html_id="bdRT"
             role="filter"/>
        </div>
        @else
        <div>
            <x-input
                name="dateMin"
                label="date début"
                type="date"
                html_id="pdDateMin"
                role="filter"
            />
            <x-input
                name="dateMax"
                label="date fin"
                type="date"
                html_id="pdDateMax"
                role="filter"
            />
        </div>
        @endif


        <div class="table__filters">
            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                     htmlId="{{ 'PDT-'.$filter['name']}}"
                     :name="$filter['name']"
                     :label="$filter['label']"
                     :data="$filter['data']"
                     type="filter"
                     />

            @endforeach
        @endif
        </div>
    </div>
    @if(isset($this->rendezVous) && $this->rendezVous->isNotEmpty())
      @if($showMoreDetails)
      <table>
          <thead>
             <tr>
             <x-sortable-th wire:key="rt-TH-1" name="code" label="Code Dossier"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-2" name="patient_last_name" label="Nom Patient"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-3" name="patient_first_name" label="Prénom Patient"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-11" name="patient_birth_date" label="date de naissance"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-4" name="day_at" label="date"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-5" name="specialty" label="spécialité"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-6" name="doctor_name" label="médecin"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-7" name="doctor_email" label="email du medecin"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-8" name="doctor_phone" label="numéro du medecin"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-9" name="establishment_name" label="établissement"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="rt-TH-10" name="cp_name" label="lieu de consultation"   :$sortDirection :$sortBy/>
             <th scope="column"><div>actions</div></th>
             </tr>
          </thead>
          <tbody>
            @foreach ($this->rendezVous as $r)
            <tr wire:key="{{ $r->id }}-rdt" scope="row">
            <td>{{ $r->code}}</td>
            <td>{{ $r->patient_last_name}}</td>
            <td>{{ $r->patient_first_name}}</td>
            <td>{{ $r->patient_birth_date}}</td>
            <td>{{ $r->day_at}}</td>
            <td>{{ $r->specialty }}</td>
            <td>{{ $r->doctor_name }}</td>
            <td>{{ $r->doctor_email }}</td>
            <td>{{ $r->doctor_phone }}</td>
            <td>{{ $r->establishment_name }}</td>
            <td>{{ $r->cp_name}}</td>
            <td>
                 @if($r->referralLetter && $r->referralLetter->url)
                 <livewire:open-modal-button
                 wire:key="'o-i-r-M-'.{{ $r->id }}"
                 classes="rounded"
                 content="<i class='fa-solid fa-file'></i>"
                 :data='[
                    "type" => "simple_img",
                    "title" => "lettre oriontation",
                    "component" =>  $r->referralLetter->url
                   ]'
                  />

             @endif

              </td>
              </tr>
            @endforeach
        </tbody>
      </table>
      @else
      <table>
        <thead>
           <tr>
           <x-sortable-th wire:key="rt-TH-4" name="day_at" label="date"   :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="rt-TH-5" name="specialty" label="spécialité"   :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="rt-TH-6" name="doctor_name" label="médecin"   :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="rt-TH-9" name="establishment_name" label="établissement"   :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="rt-TH-10" name="cp_name" label="lieu de consultation"   :$sortDirection :$sortBy/>
           <th scope="column"><div>actions</div></th>
           </tr>
        </thead>
        <tbody>
          @foreach ($this->rendezVous as $r)
          <tr wire:key="{{ $r->id }}-rdt" scope="row">
          <td>{{ $r->day_at}}</td>
          <td>{{ $r->specialty }}</td>
          <td>{{ $r->doctor_name }}</td>
          <td>{{ $r->establishment_name }}</td>
          <td>{{ $r->cp_name}}</td>
          <td>
          <livewire:open-dialog-button wire:key="'o-d-rd-'.{{ $r->id }}" classes="rounded"
              content="<i class='fa-solid fa-trash'></i>"
              :data='[
                       "question" => "supprimer le rendez vous",
                       "details" =>"Are you sure you want to delete the rendezvous with date:  $r->day_at ?",
                       "actionEvent"=>[
                                       "event"=>"delete-rendez-vous",
                                       "parameters"=>$r
                                       ]
                       ]'
               />
            <button class="button rounded" wire:click="printConfirmationPdf({{ $r }})"><i class="fa-solid fa-file-pdf"></i></button>
            </td>
            </tr>
          @endforeach
      </tbody>
    </table>

      @endif
    <div class="table__footer">
        {{-- {{ $this->establishments->links() }} --}}
    </div>
    @else
    <div class="table__footer">
        <h2>
            No Rendezvous found at the moment
        </h2>
    </div>
   @endif
</div>
