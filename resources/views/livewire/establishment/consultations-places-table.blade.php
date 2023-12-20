
<div class="table__container"  x-on:update-consultations-places-table.window="$wire.$refresh()">
    <div class="table__header">

        <div>
        </div>
        <div>
            <x-input name="name" label="Nom du lieu de consultation"  type="text" html_id="CPTName" role="filter"/>
            <x-input name="address" label="L'adresse du lieu de consultation"  type="text" html_id="CPTAddress" role="filter"/>
        </div>
        <div>
            <x-input name="tel" label="le numéro de téléphone"  type="text" html_id="CPTTel" role="filter"/>
            <x-input name="fax" label="le numéro du fax"  type="text" html_id="CPTFax" role="filter"/>
        </div>
        <div class="table__filters">

            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                     htmlId="{{ 'TCP-'.$filter['name']}}"
                     :name="$filter['name']"
                     :label="$filter['label']"
                     :data="$filter['data']"
                     type="filter"
                     />

            @endforeach
        @endif

        </div>
    </div>

    @if(isset($this->consultationsPlaces) && $this->consultationsPlaces->isNotEmpty())



    <table>
        <thead>
            <tr>
           <th></th>
           <x-sortable-th wire:key="cp-TH-1" name="name" label="Nom du lieu de consultation"   :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="cp-TH-2" name="daira" label="Daïra" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="cp-TH-3" name="address" label="L'adresse" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="cp-TH-4" name="tel" label="Numéro de téléphone" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="cp-TH-5" name="fax" label="Numéro du fax" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="cp-TH-6" name="created_at" label="Date de creation" :$sortDirection :$sortBy/>
               <th scope="column"><div>actions</div></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($this->consultationsPlaces as $cp)
                <tr wire:key="{{ $cp->id }}" >
                    <td>
                        <x-radio-button
                         model="selectedChoice"
                          htmlId="{{ 'cp-id'.$cp->id }}"
                          value="{{ $cp->id }}"
                          type="forTable"
                          event="set-userable-id-Externally"
                          wire:key="{{ 'cp-key-'.$cp->id }}"
                        />
                    </td>
                    <td scope="row">{{ $cp->name }}</td>
                    <td>{{ $cp->daira }}</td>
                    <td>{{ $cp->address }}</td>
                    <td>{{ $cp->tel }}</td>
                    <td>{{ $cp->fax }}</td>
                    <td>{{ $cp->created_at->format('d/m/Y') }}</td>
                    <td>

                        <livewire:open-dialog-button wire:key="'o-d-cp-'.{{ $cp->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :data='[
                                     "question" => "Supprimer le lieu de consultation",
                                     "details" =>"Êtes-vous sûr de vouloir supprimer le lieu de consultation  $cp->name ?",
                                     "actionEvent"=>[
                                                     "event"=>"delete-consultation-place",
                                                     "parameters"=>$cp
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="o-p-m-cp-{{ $cp->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                            :data='[
                                    "title" => "Mettre à jour le lieu de consultation",
                                     "component" => [
                                                    "name" => "establishment.    consultations-place-modal",
                                                     "parameters" => ["id" => $cp->id]]]'
                        />
                        <livewire:open-modal-button wire:key="'o-p-m-u-cp-'.{{ $cp->id }}" classes="rounded"
                            content="<i class='fa-solid fa-users'></i>"
                            :data='[
                                      "title" => "Ajouter le coordinateur du lieu de consultation",
                                    "component" => [
                                                    "name" => "user-modal",
                                                    "parameters" => [
                                                                     "userableId"=> $cp->id,"userableType"=>"admin_place_of_consultation"
                                                                     ]
                                                    ]
                                    ]'
                                   />
                    </td>
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
        Aucun lieu de consultation n'a été ajouté pour le moment.
    </h2>
    </div>
   @endif

</div>
