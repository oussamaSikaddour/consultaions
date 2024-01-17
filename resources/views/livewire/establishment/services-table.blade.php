
<div class="table__container"
x-on:update-services-table.window="$wire.$refresh()"
x-on:init="manageServicesRadioButtonsWihtKeydowEvents()">
    <div class="table__header">
        <div>
            {{-- <button class="button button--primary rounded table__button" ><i class="fa-solid fa-file-excel"></i></button> --}}
            <button class="button button--primary" wire:click="generateEmptyServicesSheet()">
            @lang("tables.services.empty-excel")
            </button>

            <x-upload-input
            model="excelFile"
            :label="__('tables.services.upload-excel-btn-txt')"
            />
        </div>
        <div>
            <x-input
             name="name"
             :label="__('tables.services.name')"
             type="text"
             html_id="serviceTName"
             role="filter"/>
            <x-input
            name="headOfService"
             :label="__('tables.services.head-service')"
             type="text"
             html_id="serviceTHOS"
             role="filter"/>
        </div>
        <div class="table__filters">

            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                     htmlId="{{ 'TS-'.$filter['name']}}"
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

    @if(isset($this->services) && $this->services->isNotEmpty())


    <div class="table__body">
    <table>
        <thead>
            <tr>
           <th></th>
           <x-sortable-th
           wire:key="s-TH-2"
           name="name"
           :label="__('tables.services.name')"
           :$sortDirection :$sortBy/>
           <x-sortable-th wire:key="s-TH-3"
           name="head_of_service"
           :label="__('tables.services.head-service')"
            :$sortDirection
            :$sortBy/>
           <x-sortable-th
           wire:key="s-TH-3"
           name="specialty"
           :label="__('tables.services.specialty')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="s-TH-4"
           name="created_at"
           :label="__('tables.services.creation-date')"
           :$sortDirection
           :$sortBy/>
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
                          wire:key="{{ 's-key-'.$s->id }}"
                        />
                    </td>
                    <td scope="row">{{ $s->name }}</td>
                    <td>{{ $s->head_of_service }}</td>
                    <td>{{ app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()][$s->specialty]}}</td>
                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                    <td>
                        <livewire:open-dialog-button wire:key="'o-d-s-'.{{ $s->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :data='[
                                     "question" => "dialogs.title.service",
                                     "details" =>["service",$s->name],
                                     "actionEvent"=>[
                                                     "event"=>"delete-service",
                                                     "parameters"=>$s
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="o-p-m-s-{{ $s->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                            :data='[
                                    "title" => "modals.service.for.update",
                                    "component" => [
                                                   "name" => "establishment.service-modal", "parameters" => ["id" => $s->id]
                                                   ]
                                   ]'
                        />
                        <livewire:open-modal-button wire:key="'o-p-m-u-s-'.{{ $s->id }}" classes="rounded"
                            content="<i class='fa-solid fa-users'></i>"
                            :data='[
                                    "title" => "modals.user.for.add-coord-service",
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
    </div>
    <div class="table__footer">
        {{-- {{ $this->establishments->links() }} --}}

    </div>

    @else
    <div class="table__footer">
    <h2>
        @lang('tables.services.not-found')
    </h2>
    </div>
   @endif

</div>


@script
<script>
function manageServicesRadioButtonsWihtKeydowEvents() {
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
