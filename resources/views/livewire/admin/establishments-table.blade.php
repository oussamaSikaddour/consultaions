
<div class="table__container"
x-on:update-establishments-table.window="$wire.$refresh()"
x-on:init="manageEstablishmentsRadioButtonsWihtKeydowEvents()"
>
    <div class="table__header">

        <div>
            {{-- <button class="button button--primary rounded table__button" ><i class="fa-solid fa-file-excel"></i></button> --}}
            <button class="button button--primary" wire:click="generateEmptyEstablishmentsSheet()">
            @lang("tables.establishments.empty-excel")
            </button>

            <x-upload-input
            model="excelFile"
            :label="__('tables.establishments.upload-excel-btn-txt')"
            />
        </div>
        <div>
            <x-input name="acronym"
            :label="__('tables.establishments.acronym')"
            type="text"
            html_id="establishmenAcronym"
            role="filter"/>
            <x-input
             name="name"
             :label="__('tables.establishments.name')"
             type="text"
             html_id="establishmentName"
             role="filter"/>

        </div>
        <div>
            <x-input
              name="email"
              :label="__('tables.establishments.email')"
              type="text"
              html_id="establishmentEmail"
               role="filter"/>
        </div>
        <div class="table__filters">

            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                      htmlId="{{ 'TEF-'.$filter['name']}}"
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

    @if(isset($this->establishments) && $this->establishments->isNotEmpty())


    <div class="table__body">
    <table>
        <thead>
            <tr>
           <th></th>
           <x-sortable-th
           wire:key="E-TH-1"
           name="acronym"
           :label="__('tables.establishments.acronym')"
           :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="E-TH-2"
           name="name"
           :label="__('tables.establishments.name')"
            :$sortDirection :$sortBy/>
           <x-sortable-th
           wire:key="E-TH-3"
           name="email"
            :label="__('tables.establishments.email')"
            :$sortDirection :$sortBy/>
             <th scope="column"><div>@lang('tables.establishments.address')</div></th>
             <th scope="column"><div>@lang('tables.establishments.land-line-number')</div></th>
             <th scope="column"><div>@lang('tables.establishments.fax-number')</div></th>
            <x-sortable-th
            wire:key="E-TH-4"
             name="created_at"
             :label="__('tables.establishments.creation-date')"
             :$sortDirection :$sortBy/>
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
                                     "question" => "dialogs.title.establishment",
                                     "details" =>["establishment",$e->name],
                                     "actionEvent"=>[
                                                     "event"=>"delete-establishment",
                                                     "parameters"=>$e
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="o-p-m-{{ $e->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                            :data='[
                                  "title" => "modals.establishment.for.update",
                                  "component" => [
                                                 "name" => "admin.establishment-modal",   "parameters" => ["id" => $e->id]
                                                 ]
                                    ]'
                        />
                        <livewire:open-modal-button wire:key="'o-p-m-u'.{{ $e->id }}" classes="rounded"
                            content="<i class='fa-solid fa-users'></i>"
                            :data='[

                                "title" => "modals.user.for.add-admin-establishment",
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
    </div>
    <div class="table__footer">
        {{-- {{ $this->establishments->links() }} --}}

    </div>
    @else
    <div class="table__footer">
    <h2>
        @lang('tables.establishments.not-found')
    </h2>
    </div>
   @endif

</div>

@script
<script>
function manageEstablishmentsRadioButtonsWihtKeydowEvents() {
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
