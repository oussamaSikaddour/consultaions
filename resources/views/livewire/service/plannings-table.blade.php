@php
        $months= app('my_constants')['MONTHS']
@endphp
<div class="table__container"
x-on:update-plannings-table.window="$wire.$refresh()"
 >
    <div class="table__header">

        <div>

        </div>
        <div>
            <x-input name="name" label="Nom du Planning"  type="text" html_id="planningTName" role="filter"/>
        </div>
        <div class="table__filters">

            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)


                    <x-selector
                     htmlId="{{ 'TP-'.$filter['name']}}"
                     :name="$filter['name']"
                     :label="$filter['label']"
                     :data="$filter['data']"
                     type="filter"
                     />

            @endforeach
        @endif

        </div>
    </div>

    @if(isset($this->plannings) && $this->plannings->isNotEmpty())



    <table>
        <thead>
            <tr>
           <th></th>
           <x-sortable-th wire:key="pl-TH-1" name="name" label="Nom de planning"
            :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="pl-TH-2" name="year" label="Année" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="pl-TH-3" name="month" label="Mois" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="pl-TH-4" name="state" label="Etat" :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="pl-TH-5" name="created_at" label="Date de creation" :$sortDirection :$sortBy/>
           <th scope="column"><div>actions</div></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($this->plannings as $p)
                <tr wire:key="{{ $p->id }}" >
                    <td>
                        <x-radio-button
                         model="selectedChoice"
                          htmlId="{{ 'p-id'.$p->id }}"
                          value="{{ $p->id }}"
                          type="forTable"
                          event="set-planning-id-externally"
                          wire:key="{{ 'pl-key-'.$p->id }}"
                        />
                    </td>
                    <td scope="row">{{ $p->name }}</td>
                    <td>{{ $p->year }}</td>
                    <td>{{ $months[$p->month - 1] }}</td>
                    <td>{{ $p->state }}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($p->state==="non publié")
                        <livewire:open-dialog-button wire:key="'o-d-pl-'.{{ $p->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :data='[
                                     "question" => "supprimer le planning",
                                     "details" =>"Are you sure you want to delete  $p->name ?",
                                     "actionEvent"=>[
                                                     "event"=>"delete-planning",
                                                     "parameters"=>$p
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="o-p-m-pl-{{ $p->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                            :data='[
                            "title" => "Modifier Planning",
                            "component" =>[
                                          "name" => "service.planning-modal",
                                          "parameters" => ["id" => $p->id]]]'
                        />
                        <livewire:open-modal-button wire:key="'o-p-m-pl-d-'.{{ $p->id }}"            classes="rounded"
                                content="<i class='fa-solid fa-calendar'></i>"
                                :data='[
                                       "title" => "Ajout Jour Du Planning",
                                       "component" => [
                                                       "name" => "service.plannings-day-modal",
                                                       "parameters" => [
                                                           "planningId"=> $p->id]
                                                        ]
                                        ]'
                                   />
                    @else
                    <div>Déjà publié</div>
                    @endif
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
        No plannings have been added at the moment.
    </h2>
    </div>
   @endif
</div>
