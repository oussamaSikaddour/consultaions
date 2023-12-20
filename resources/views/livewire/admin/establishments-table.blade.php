
<div class="table__container"  x-on:update-establishments-table.window="$wire.$refresh()">
    <div class="table__header">

        <div>
            {{-- <button class="button button--primary rounded table__button" ><i class="fa-solid fa-file-excel"></i></button> --}}
        </div>
        <div>
            <x-input name="acronym" label="abréviation du nom"  type="text" html_id="establishmenAcronym" role="filter"/>
            <x-input name="name" label="nom"  type="text" html_id="establishmentName" role="filter"/>

        </div>
        <div>
            <x-input name="email" label="email"  type="text" html_id="establishmentEmail" role="filter"/>
        </div>
        <div class="table__filters">

            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                      htmlId="{{ 'TEF-'.$filter['name']}}"
                     :name="$filter['name']"
                     :label="$filter['label']"
                     :data="$filter['data']"
                     type="filter"
                     />

            @endforeach
        @endif

        </div>
    </div>

    @if(isset($this->establishments) && $this->establishments->isNotEmpty())



    <table>
        <thead>
            <tr>
           <th></th>
           <x-sortable-th wire:key="E-TH-1" name="acronym" label="abréviation du nom" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="E-TH-2" name="name" label="Nom"   :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="E-TH-3" name="email" label="Email" :$sortDirection :$sortBy/>
             <th scope="column"><div>Adresse</div></th>
             <th scope="column"><div>numéro du fix</div></th>
             <th scope="column"><div>numéro du fax</div></th>
            <x-sortable-th wire:key="E-TH-4" name="created_at" label="date de creation" :$sortDirection :$sortBy/>
             <th scope="column"><div>actions</div></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($this->establishments as $e)
                <tr wire:key="{{ $e->id }}">
                    <td>
                        <x-radio-button
                         model="selectedChoice"
                          htmlId="{{ 'e-id'.$e->id }}"
                          value="{{ $e->id }}"
                          type="forTable"
                          event="set-userable-id-Externally"
                          wire:key="{{ 'e-key-'.$e->id }}"
                        />
                    </td>
                    <td scope="row">{{ $e->acronym }}</td>
                    <td  >{{ $e->name }}</td>
                    <td >{{ $e->email }}</td>
                    <td >{{ $e->address }}</td>
                    <td >{{ $e->tel }}</td>
                    <td >{{ $e->fax }}</td>
                    <td >{{ $e->created_at->format('d/m/Y')}}</td>
                    <td>
                        <livewire:open-dialog-button wire:key="'o-d-e-'.{{ $e->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :data='[
                                     "question" => "supprimer l établissement",
                                     "details" =>"Are you sure you want to delete  $e->name ?",
                                     "actionEvent"=>[
                                                     "event"=>"delete-establishment",
                                                     "parameters"=>$e
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="o-p-m-{{ $e->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                            :data='[
                                  "title" => "modifier establishement",
                                  "component" => [
                                                 "name" => "admin.establishment-modal",   "parameters" => ["id" => $e->id]
                                                 ]
                                    ]'
                        />
                        <livewire:open-modal-button wire:key="'o-p-m-u'.{{ $e->id }}" classes="rounded"
                            content="<i class='fa-solid fa-users'></i>"
                            :data='[

                                "title" => "ajour User",
                                 "component" => [
                                                "name" => "user-modal",
                                                "parameters" => [
                                                              "userableId"=> $e->id,"userableType"=>"admin_establishment"]
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
        Aucun établissement n'a été ajouté pour le moment.
    </h2>
    </div>
   @endif

</div>
