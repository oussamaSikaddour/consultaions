
@php
$showForDoctor= isset($showForDoctor) ? $showForDoctor:false;
@endphp
<div class="table__container"
 x-on:update-medical-files-table.window="$wire.$refresh()"
 x-on:init="manageMFilesRadioButtonsWihtKeydowEvents()"
 >
    <div class="table__header">
        <div>
            {{-- <button class="button button--primary rounded table__button"  wire:click="generateExcel">
                <i class="fa-solid fa-file-excel"></i></button> --}}
        </div>
        <div>
            <x-input
            name="code"
           :label="__('tables.m-files.code')"
            type="text"
            html_id="codeMFT"
            role="filter"/>
            <x-input
            name="birthDate"
            :label="__('tables.m-files.birth-d')"
            type="date"
            html_id="bdMFT"
            role="filter"/>
        </div>
        <div>
            <x-input
            name="lastName"
            :label="__('tables.m-files.l-name')"
            type="text"
            html_id="LNameMFT"
            role="filter"/>
            <x-input
            name="firstName"
           :label="__('tables.m-files.f-name')"
            type="text"
             html_id="FNameMFT"
              role="filter"/>
        </div>
        <div class="table__filters">
            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                     htmlId="{{ 'PDT-'.$filter['name']}}"
                     :name="$filter['name']"
                     :label="$filter['label']"
                     :data="$filter['data']"
                     :toTranslate="$filter['toTranslate']"
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
    @if(isset($this->medicalFiles) && $this->medicalFiles->isNotEmpty())
    <div class="table__body">
      <table>
          <thead>
             <tr>
                <th></th>
             <x-sortable-th
             wire:key="mft-TH-1"
              name="code"
              :label="__('tables.m-files.code')"
               :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="mft-TH-2"
             name="last_name"
              :label="__('tables.m-files.l-name')"
              :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="mft-TH-3"
             name="first_name"
             :label="__('tables.m-files.f-name')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="mft-TH-4"
             name="birth_date"
             :label="__('tables.m-files.birth-d')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="mft-TH-5"
             name="tel"
              :label="__('tables.m-files.phone-number')"
              :$sortDirection :$sortBy/>
             <x-sortable-th
             wire:key="pdt-TH-6"
             name="created_at"
             :label="__('tables.m-files.creation-date')"
             :$sortDirection :$sortBy/>
             <th scope="column"><div>actions</div></th>
             </tr>
          </thead>
          <tbody>


             @foreach ($this->medicalFiles as $mf)
             <tr wire:key="{{ $mf->id }}" scope="row">
                <td>
                    <x-radio-button
                      model="selectedChoice"
                      htmlId="{{ 'md-id'.$mf->id }}"
                      value="{{ $mf->id }}"
                      type="forTable"
                      wire:key="{{ 'mf-key-'.$mf->id }}"
                    />
                </td>
             <td>{{ $mf->code}}</td>
             <td>{{ $mf->last_name}}</td>
             <td>{{ $mf->first_name}}</td>
             <td>{{ $mf->birth_date}}</td>
             <td>{{ $mf->tel}}</td>
             <td>{{ $mf->created_at->format('d/m/Y')}}</td>
            <td>

                @if($showForDoctor)

                <livewire:open-modal-button wire:key="'o-pd-pl-d-'.{{ $mf->id }}"            classes="rounded"
                    content="<i class='fa-solid fa-calendar'></i>"
                    :data='[
                           "title" => "modals.rendez-vous.for.add-control",
                           "component" => [
                                           "name" => "control-modal",
                                           "parameters" => [
                                            "medicalFileId"=> $mf->id,
                                            "doctorId"=>$doctorId ? $doctorId:""
                                            ]
                                            ]
                            ]'
                       />
                @else

                @if($mf->rendez_vous_count === 0)
                <livewire:open-dialog-button wire:key="'o-d-mfd-'.{{ $mf->id }}" classes="rounded"
                    content="<i class='fa-solid fa-trash'></i>"
                    :data='[
                             "question" => "dialogs.title.m-file",
                             "details" =>["m-file", $mf->code],
                             "actionEvent"=>[
                                             "event"=>"delete-medical-file",
                                             "parameters"=>$mf
                                             ]
                             ]'
                     />
                    @endif
               <livewire:open-modal-button wire:key="'pd-b-mf-'.{{ $mf->id }}" classes="rounded"
                content="<i class='fa-solid fa-pen-to-square'></i>"
                :data='[
                         "title" => "modals.m-file.for.update",
                         "component" => [
                                          "name" => "user.medical-file-modal",
                                           "parameters" => ["id"=>$mf->id]
                                        ]
                       ]'
                 />
                 <livewire:open-modal-button wire:key="'o-pd-pl-d-'.{{ $mf->id }}"            classes="rounded"
                    content="<i class='fa-solid fa-calendar'></i>"
                    :data='[
                           "title" => "modals.rendez-vous.for.add",
                           "component" => [
                                           "name" => "rendezvous-modal",
                                           "parameters" => [
                                            "medicalFileId"=> $mf->id
                                            ]
                                            ]
                            ]'
                       />
                @endif

         </tr>
       @endforeach

        </tbody>
    </table>
    </div>
    <div class="table__footer">
        {{-- {{ $this->establishments->links() }} --}}
    </div>
    @else
    <div class="table__footer">
        <h2>
            @lang('tables.m-files.not-found')
        </h2>
    </div>
   @endif
</div>




@script
<script>
function manageMFilesRadioButtonsWihtKeydowEvents() {
  const radioButtons = document.querySelectorAll('.radio__button');
  // Consolidated event listener for all radio buttons:
  document.addEventListener('keydown', (e) => {
    if (e.key === ' ' && e.target.closest('.radio__button')) {
      e.preventDefault();

      const radioButton = e.target.closest('.radio__button');
      const radioInput = radioButton.querySelector("input[type='radio']");
      checkRadio(radioInput, radioButtons);
      @this.selectedChoice= radioInput.value;
      @this.callUpdatedSelectedChoiceOnKeyDownEvent();
    }
  });
}
</script>
@endscript
