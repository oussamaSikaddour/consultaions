
@php
$showForDoctor= isset($showForDoctor) ? $showForDoctor:false;
@endphp
<div class="table__container"
 x-on:update-medical-files-table.window="$wire.$refresh()"
 >
    <div class="table__header">
        <div>
            {{-- <button class="button button--primary rounded table__button"  wire:click="generateExcel">
                <i class="fa-solid fa-file-excel"></i></button> --}}
        </div>
        <div>
            <x-input name="code" label="code dossier"  type="text" html_id="codeMFT" role="filter"/>
            <x-input name="birthDate" label="date de naissance"  type="date" html_id="bdMFT" role="filter"/>
        </div>
        <div>
            <x-input name="lastName" label="nom"  type="text" html_id="LNameMFT" role="filter"/>
            <x-input name="firstName" label="prénom "  type="text" html_id="FNameMFT" role="filter"/>
        </div>
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
    @if(isset($this->medicalFiles) && $this->medicalFiles->isNotEmpty())
      <table>
          <thead>
             <tr>
                <th></th>
             <x-sortable-th wire:key="mft-TH-1" name="code" label="Code Dossier"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="mft-TH-2" name="last_name" label="Nom"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="mft-TH-3" name="first_name" label="Prénom"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="mft-TH-4" name="birth_date" label="Date de naissance"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="mft-TH-5" name="tel" label="Numéro de téléphone"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="pdt-TH-6" name="created_at" label="date de creation" :$sortDirection :$sortBy/>
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
                      event="set-medical-file-id-Externally"
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
                           "title" => "Prendre un rendez-vous  de contrôle",
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
                             "question" => "supprimer le dossier médical",
                             "details" =>"Are you sure you want to delete the medical file:  $mf->code?",
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
                         "title" => "mettre à jour le dossier médical",
                         "component" => [
                                          "name" => "user.medical-file-modal",
                                           "parameters" => ["id"=>$mf->id]
                                        ]
                       ]'
                 />
                 <livewire:open-modal-button wire:key="'o-pd-pl-d-'.{{ $mf->id }}"            classes="rounded"
                    content="<i class='fa-solid fa-calendar'></i>"
                    :data='[
                           "title" => "Prendre un rendez-vous",
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
    <div class="table__footer">
        {{-- {{ $this->establishments->links() }} --}}
    </div>
    @else
    <div class="table__footer">
        <h2>
            No medical files found at the moment
        </h2>
    </div>
   @endif
</div>



