
<div class="table__container"  x-on:update-plannings-days-table.window="$wire.$refresh()">
    <div class="table__header">
        <div>
            <button class="button button--primary rounded table__button"  wire:click="generateExcel"><i class="fa-solid fa-file-excel"></i></button>
        </div>
        <div>
            <x-input name="dayAt" label="la date"  type="date" html_id="dayAtPDT" role="filter"/>
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
    @if(isset($this->planningDays) && $this->planningDays->isNotEmpty())
      <table>
          <thead>
             <tr>
             <x-sortable-th wire:key="pdt-TH-1" name="day_at" label="Date"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="pdt-TH-2" name="doctor_name" label="medecin" :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="pdt-TH-3" name="planning_name" label="planning" :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="pdt-TH-4" name="consultation_place_name" label="planning" :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="pdt-TH-5" name="number_of_consultation" label="number de consultation" :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="pdt-TH-6" name="number_of_rendez_vous" label="number de rendez-vous" :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="pdt-TH-7" name="created_at" label="date de creation" :$sortDirection :$sortBy/>
             <th scope="column"><div>actions</div></th>
             </tr>
          </thead>
          <tbody>


             @foreach ($this->planningDays as $p)
             <tr wire:key="{{ $p->id }}" scope="row">
             <td>{{ $p->day_at}}</td>
             <td>{{ $p->doctor_name}}</td>
             <td>{{ $p->planning_name}}</td>
             <td>{{ $p->consultation_place_name}}</td>
             <td>{{ $p->number_of_consultation}}</td>
             <td>{{ $p->number_of_rendez_vous}}</td>
             <td>{{ $p->created_at->format('d/m/Y')}}</td>
            <td>
            @if($p->planning->state==="non publié")
            <livewire:open-dialog-button wire:key="'o-d-pld-'.{{ $p->id }}" classes="rounded"
                content="<i class='fa-solid fa-trash'></i>"
                :data='[
                         "question" => "supprimer le planning",
                         "details" =>"Are you sure you want to delete the planning day $p->day_at?",
                         "actionEvent"=>[
                                         "event"=>"delete-planning-day",
                                         "parameters"=>$p
                                         ]
                         ]'
                 />
           <livewire:open-modal-button wire:key="'pd-b-u-'.{{ $p->id }}" classes="rounded"
            content="<i class='fa-solid fa-pen-to-square'></i>"
            :data='[
                    "title" => "mettre à jour l planning day",
                      "component" => [
                                      "name" => "service.plannings-day-modal",
                                      "parameters" => ["id"=>$p->id]
                                      ]
                  ]'
             />

             @else
             <div>Déjà publié</div>
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
            No planning days found for the selected service at the moment
        </h2>
    </div>
   @endif
</div>



