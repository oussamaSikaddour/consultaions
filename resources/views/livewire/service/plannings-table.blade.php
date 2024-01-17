@php
$months= app('my_constants')['MONTHS'][app()->getLocale()]
@endphp
<div class="table__container"
x-on:update-plannings-table.window="$wire.$refresh()"
x-on:wire="managePlanningsRadioButtonsWihtKeydowEvents()"
 >
    <div class="table__header">

        <div>

        </div>
        <div>
            <x-input
            name="name"
            :label="__('tables.plannings.name')"
            type="text"
             html_id="planningTName"
              role="filter"/>
        </div>
        <div class="table__filters">

            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                     htmlId="{{ 'TP-'.$filter['name']}}"
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

    @if(isset($this->plannings) && $this->plannings->isNotEmpty())

    <div class="table__body">
    <table>
        <thead>
            <tr>
           <th></th>
           <x-sortable-th
           wire:key="pl-TH-1"
           name="name"
           :label="__('tables.plannings.name')"
            :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="pl-TH-2"
            name="year"
            :label="__('tables.plannings.year')"
            :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="pl-TH-3"
            name="month"
            :label="__('tables.plannings.month')"
            :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="pl-TH-4"
           name="state"
          :label="__('tables.plannings.state')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="pl-TH-5"
            name="created_at"
            :label="__('tables.plannings.creation-date')"
            :$sortDirection :$sortBy/>
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
                         wire:key="{{ 'p-key-'.$p->id }}"
                       />
                    </td>
                    <td scope="row">{{ $p->name }}</td>
                    <td>{{ $p->year }}</td>
                    <td>{{ $months[$p->month - 1] }}</td>
                    <td>{{app('my_constants')['PLANNING_STATE'][app()->getLocale()][$p->state]}}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($p->state==="not_published")
                        <livewire:open-dialog-button wire:key="'o-d-pl-'.{{ $p->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :data='[
                                     "question" => "dialogs.title.planning",
                                     "details" =>["planning", $p->name],
                                     "actionEvent"=>[
                                                     "event"=>"delete-planning",
                                                     "parameters"=>$p
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="o-p-m-pl-{{ $p->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                            :data='[
                            "title" => "modals.planning.for.update",
                            "component" =>[
                                          "name" => "service.planning-modal",
                                          "parameters" => ["id" => $p->id]]]'
                        />
                        <livewire:open-modal-button wire:key="'o-p-m-pl-d-'.{{ $p->id }}"            classes="rounded"
                                content="<i class='fa-solid fa-calendar'></i>"
                                :data='[
                                       "title" => "modals.planning-day.for.add",
                                       "component" => [
                                                       "name" => "service.plannings-day-modal",
                                                       "parameters" => [
                                                           "planningId"=> $p->id]
                                                        ]
                                        ]'
                                   />
                    @else
                    <div>@lang("tables.plannings.already-published")</div>
                    @endif
                    </td>
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
        @lang("tables.plannings.not-found")
    </h2>
    </div>
   @endif
</div>


@script
<script>
function managePlanningsRadioButtonsWihtKeydowEvents() {
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
