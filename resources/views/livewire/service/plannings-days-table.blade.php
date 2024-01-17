
<div class="table__container"
 x-on:update-plannings-days-table.window="$wire.$refresh()">
    <div class="table__header">
        <div>
            <button class="button button--primary rounded table__button"  wire:click="generatePlanningDaysExcel"><i class="fa-solid fa-file-excel"></i></button>
        </div>
        <div>
            <x-input
            name="dayAt"
            :label="__('tables.planning-days.date')"
            type="date"
            html_id="dayAtPDT"
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
    @if(isset($this->planningDays) && $this->planningDays->isNotEmpty())
    <div class="table__body">
    <table>
          <thead>
             <tr>
             <x-sortable-th
             wire:key="pdt-TH-1"
             name="day_at"
             :label="__('tables.planning-days.date')"
             :$sortDirection :$sortBy/>
             <x-sortable-th
              wire:key="pdt-TH-2"
               name="doctor_name"
               :label="__('tables.planning-days.doctor')"
               :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="pdt-TH-4"
              name="consultation_place_name"
              :label="__('tables.planning-days.c-place')"
               :$sortDirection :$sortBy/>
             <x-sortable-th
              wire:key="pdt-TH-5"
              name="number_of_consultation"
              :label="__('tables.planning-days.c-number')"
              :$sortDirection :$sortBy/>
             <th scope="column"><div>actions</div></th>
             </tr>
          </thead>
          <tbody>


             @foreach ($this->planningDays as $p)
             <tr wire:key="{{ $p->id }}" scope="row">
             <td>{{ $p->day_at}}</td>
             <td>{{ $p->doctor_name}}</td>
             <td>{{ $p->consultation_place_name}}</td>
             <td>{{ $p->number_of_consultation}}</td>
            <td>
            @if($p->planning->state==="not_published")
            <livewire:open-dialog-button wire:key="'o-d-pld-'.{{ $p->id }}" classes="rounded"
                content="<i class='fa-solid fa-trash'></i>"
                :data='[
                         "question" => "dialogs.title.planning-day",
                         "details" =>["planning-day", $p->day_at],
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
             <div>@lang("tables.planning-days.already-published")</div>
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
            @lang('tables.planning-days.not-found')
        </h2>
    </div>
   @endif
</div>



