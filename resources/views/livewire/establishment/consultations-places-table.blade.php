
<div class="table__container"
x-on:update-consultations-places-table.window="$wire.$refresh()"
x-on:init="manageCPlacesRadioButtonsWihtKeydowEvents()"
>
    <div class="table__header">
        <div>
            {{-- <button class="button button--primary rounded table__button" ><i class="fa-solid fa-file-excel"></i></button> --}}
            <button class="button button--primary" wire:click="generateEmptyCPlacesSheet()">
            @lang("tables.c-places.empty-excel")
            </button>

            <x-upload-input
            model="excelFile"
            :label="__('tables.c-places.upload-excel-btn-txt')"
            />
        </div>
        <div>
            <x-input
            name="name"
            :label="__('tables.c-places.name')"
            type="text"
            html_id="CPTName"
            role="filter"/>
            <x-input
            name="address"
            :label="__('tables.c-places.address')"
             type="text"
             html_id="CPTAddress"
             role="filter"/>
        </div>
        <div>
            <x-input
            name="tel"
            :label="__('tables.c-places.land-line-number')"
            type="text"
            html_id="CPTTel"
            role="filter"/>
            <x-input
            name="fax"
            :label="__('tables.c-places.fax-number')"
            type="text"
            html_id="CPTFax"
             role="filter"/>
        </div>
        <div class="table__filters">

            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                     htmlId="{{ 'TCP-'.$filter['name']}}"
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

    @if(isset($this->consultationsPlaces) && $this->consultationsPlaces->isNotEmpty())


    <div class="table__body">
    <table>
        <thead>
            <tr>
           <th></th>
           <x-sortable-th
           wire:key="cp-TH-1"
           name="name"
           :label="__('tables.c-places.name')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="cp-TH-2"
           name="daira"
           :label="__('tables.c-places.filters.daira')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="cp-TH-3"
           name="address"
           :label="__('tables.c-places.address')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="cp-TH-4"
            name="tel"
            :label="__('tables.c-places.land-line-number')"
            :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="cp-TH-5"
           name="fax"
           :label="__('tables.c-places.fax-number')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="cp-TH-6"
           name="created_at"
           :label="__('tables.c-places.creation-date')"
           :$sortDirection :$sortBy/>
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
                          wire:key="{{ 'cp-key-'.$cp->id }}"
                        />
                    </td>
                    <td scope="row">{{ $cp->name }}</td>
                    <td>{{app('my_constants')['DAIRAS'][app()->getLocale()][$cp->daira]  }}</td>
                    <td>{{ $cp->address }}</td>
                    <td>{{ $cp->tel }}</td>
                    <td>{{ $cp->fax }}</td>
                    <td>{{ $cp->created_at->format('d/m/Y') }}</td>
                    <td>

                        <livewire:open-dialog-button wire:key="'o-d-cp-'.{{ $cp->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :data='[
                                     "question" => "dialogs.title.c-place",
                                     "details" =>["c-place",$cp->name],
                                     "actionEvent"=>[
                                                     "event"=>"delete-consultation-place",
                                                     "parameters"=>$cp
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="o-p-m-cp-{{ $cp->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                            :data='[
                                    "title" => "modals.c-place.for.update",
                                     "component" => [
                                                    "name" => "establishment.    consultations-place-modal",
                                                     "parameters" => ["id" => $cp->id]]]'
                        />
                        <livewire:open-modal-button wire:key="'o-p-m-u-cp-'.{{ $cp->id }}" classes="rounded"
                            content="<i class='fa-solid fa-users'></i>"
                            :data='[
                                      "title" => "modals.user.for.add-coord-c-place",
                                    "component" => [
                                                    "name" => "user-modal",
                                                    "parameters" => [
                                                                     "userableId"=> $cp->id,"userableType"=>"admin_place_of_consultation"
                                                                     ]
                                                    ]
                                    ]'
                                   />
                     <x-open-google-map
                         latitude="{{ $cp->latitude }}"
                        longitude="{{ $cp->longitude }}" />


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
        @lang("tables.c-places.not-found")
    </h2>
    </div>
   @endif




 @script
<script>
function manageCPlacesRadioButtonsWihtKeydowEvents() {
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
