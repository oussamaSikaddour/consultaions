
<div class="table__container"
 x-on:update-rendez-vous-table.window="$wire.$refresh()"
 >
    <div class="table__header">
        <div>
            @if($showForCPlaceAdmin)
            <button class="button button--primary rounded table__button"  wire:click="generateRendezVousExcel">
                <i class="fa-solid fa-file-excel"></i></button>
            @endif
        </div>
        @if($showForCPlaceAdmin || $showForDoctor)
        <div>
              <x-input
              name="dayAt"
              :label="__('tables.rendez-vous.date')"
              type="date"
              html_id="pdDayAt"
              role="filter"
          />
        </div>

        <div>
            <x-input
            name="patient"
            :label="__('tables.rendez-vous.name')"
             type="text"
             html_id="patientRT"
             role="filter"/>
            <x-input
            name="birthDate"
            :label="__('tables.rendez-vous.birth-d')"
             type="date"
             html_id="bdRT"
             role="filter"/>
        </div>
        @else
        <div>
            <x-input
                name="dateMin"
               :label="__('tables.rendez-vous.start-d')"
                type="date"
                html_id="pdDateMin"
                role="filter"
            />
            <x-input
                name="dateMax"
                :label="__('tables.rendez-vous.end-d')"
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
        <div>
            <button class="button button--primary rounded" wire:click="resetFilters">
                <i class="fa-solid fa-arrows-rotate"></i>
            </button>
        </div>
    </div>
    @if(isset($this->rendezVous) && $this->rendezVous->isNotEmpty())
      @if($showForCPlaceAdmin || $showForDoctor)
      <table>
          <thead>
             <tr>
             <x-sortable-th wire:key="rt-TH-1"
             name="code"
             :label="__('tables.rendez-vous.mf-code')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-2"
              name="patient_last_name"
              :label="__('tables.rendez-vous.patient-l-name')"
              :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-3"
              name="patient_first_name"
              :label="__('tables.rendez-vous.patient-f-name')"
              :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-11"
             name="patient_birth_date"
             :label="__('tables.rendez-vous.birth-d')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-4"
             name="day_at"
             :label="__('tables.rendez-vous.date')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-8"
             name="type"
             :label="__('tables.rendez-vous.type')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-5"
             name="specialty"
            :label="__('tables.rendez-vous.specialty')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-6"
             name="doctor_name"
             :label="__('tables.rendez-vous.doctor')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-7"
             name="doctor_email"
             :label="__('tables.rendez-vous.d-email')"
              :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-9"
             name="establishment_name"
             :label="__('tables.rendez-vous.establishment')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="rt-TH-10"
             name="cp_name"
             :label="__('tables.rendez-vous.c-place')"
              :$sortDirection :$sortBy/>
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
            <td>{{ app('my_constants')['RENDEZ_VOUS_TYPE'][app()->getLocale()][$r->type]}}</td>
            <td>{{ app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()][$r->specialty]}}</td>
            <td>{{ $r->doctor_name }}</td>
            <td>{{ $r->doctor_email }}</td>
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
           <x-sortable-th
           wire:key="rt-TH-4"
           name="day_at"
           :label="__('tables.rendez-vous.date')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="rt-TH-8"
           name="type"
           :label="__('tables.rendez-vous.type')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="rt-TH-5"
           name="specialty"
           :label="__('tables.rendez-vous.specialty')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="rt-TH-6"
           name="doctor_name"
           :label="__('tables.rendez-vous.doctor')"
             :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="rt-TH-9"
            name="establishment_name"
            :label="__('tables.rendez-vous.establishment')"
              :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="rt-TH-10"
           name="cp_name"
           :label="__('tables.rendez-vous.c-place')"
           :$sortDirection :$sortBy/>
           <th scope="column"><div>actions</div></th>
           </tr>
        </thead>
        <tbody>
          @foreach ($this->rendezVous as $r)
          <tr wire:key="{{ $r->id }}-rdt" scope="row">
          <td>{{ $r->day_at}}</td>
          <td>{{ app('my_constants')['RENDEZ_VOUS_TYPE'][app()->getLocale()][$r->type]}}</td>
          <td>{{ app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()][$r->specialty]}}</td>
          <td>{{ $r->doctor_name }}</td>
          <td>{{ $r->establishment_name }}</td>
          <td>{{ $r->cp_name}}</td>
          <td>
          <livewire:open-dialog-button wire:key="'o-d-rd-'.{{ $r->id }}" classes="rounded"
              content="<i class='fa-solid fa-trash'></i>"
              :data='[
                       "question" => "dialogs.title.rendez-vous",
                       "details" =>["rendez-vous", $r->day_at],
                       "actionEvent"=>[
                                       "event"=>"delete-rendez-vous",
                                        "parameters"=>$r
                                       ]
                       ]'
               />
            <button class="button rounded" wire:click="printConfirmationPdf({{ $r }})">
                <i class="fa-solid fa-file-pdf"></i>
            </button>
            <x-open-google-map
            latitude="{{ $r->cp_latitude }}"
           longitude="{{ $r->cp_longitude }}" />
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
         @lang('tables.rendez-vous.not-found')
        </h2>
    </div>
   @endif
</div>
