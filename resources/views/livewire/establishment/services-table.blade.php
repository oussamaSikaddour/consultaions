
<div class="table__container"  x-on:update-services-table.window="$wire.$refresh()">
    <div class="table__header">

        <div>
        </div>
        <div>
            <x-input name="name" label="Nom de service"  type="text" html_id="serviceTName" role="filter"/>
            <x-input name="headOfService" label="Le chef de service"  type="text" html_id="serviceTHOS" role="filter"/>
        </div>
        <div class="table__filters">

            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                     htmlId="{{ 'TS-'.$filter['name']}}"
                     :name="$filter['name']"
                     :label="$filter['label']"
                     :data="$filter['data']"
                     type="filter"
                     />
            @endforeach
        @endif

        </div>
    </div>

    @if(isset($this->services) && $this->services->isNotEmpty())



    <table>
        <thead>
            <tr>
           <th></th>
           <x-sortable-th wire:key="s-TH-2" name="name" label="Nom de service"   :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="s-TH-3" name="head_of_service" label="Chef de service" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="s-TH-3" name="specialty" label="Spécialité de service" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="s-TH-4" name="created_at" label="Date de creation" :$sortDirection :$sortBy/>
           <th scope="column"><div>actions</div></th>

            </tr>
        </thead>

        <tbody>
            @foreach ($this->services as $s)
                <tr wire:key="{{ $s->id }}" >
                    <td>
                        <x-radio-button
                         model="selectedChoice"
                          htmlId="{{ 's-id'.$s->id }}"
                          value="{{ $s->id }}"
                          type="forTable"
                          event="set-userable-id-Externally"
                          wire:key="{{ 's-key-'.$s->id }}"
                        />
                    </td>
                    <td scope="row">{{ $s->name }}</td>
                    <td>{{ $s->head_of_service }}</td>
                    <td>{{ $s->specialty}}</td>
                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                    <td>
                        <livewire:open-dialog-button wire:key="'o-d-s-'.{{ $s->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :data='[
                                     "question" => "Supprimer le service",
                                     "details" =>"Êtes-vous sûr de vouloir supprimer le service$s->name ?",
                                     "actionEvent"=>[
                                                     "event"=>"delete-service",
                                                     "parameters"=>$s
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="o-p-m-s-{{ $s->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                            :data='[
                                    "title" => "mise à jour du service",
                                    "component" => [
                                                   "name" => "establishment.service-modal", "parameters" => ["id" => $s->id]
                                                   ]
                                   ]'
                        />
                        <livewire:open-modal-button wire:key="'o-p-m-u-s-'.{{ $s->id }}" classes="rounded"
                            content="<i class='fa-solid fa-users'></i>"
                            :data='[
                                    "title" => "Ajout de coordinateur",
                                    "component" => [
                                                    "name" => "user-modal",
                                                     "parameters" => [
                                                            "userableId"=> $s->id,"userableType"=>"admin_service"]
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
        Aucun service trouvé pour le moment.
    </h2>
    </div>
   @endif

</div>
