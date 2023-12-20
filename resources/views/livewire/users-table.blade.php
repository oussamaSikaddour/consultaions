
<div class="table__container"  x-on:update-users-table.window="$wire.$refresh()">
    <div class="table__header">
        <div>
            <button class="button button--primary rounded table__button"  wire:click="generateExcel()"><i class="fa-solid fa-file-excel"></i></button>
        </div>
        <div>
            <x-input name="fullName" label="nom"  type="text" html_id="fullNameUT" role="filter"/>
            <x-input name="email" label="email"  type="text" html_id="usersEmailUT" role="filter"/>
        </div>
        <div class="table__filters">
            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-selector
                     htmlId="{{ 'TU-'.$filter['name']}}"
                     :name="$filter['name']"
                     :label="$filter['label']"
                     :data="$filter['data']"
                     type="filter"
                     />

            @endforeach
        @endif
        </div>
    </div>
    @if(isset($this->users) && $this->users->isNotEmpty())
      <table>
          <thead>
             <tr>
             <x-sortable-th wire:key="U-TH-2" name="name" label="Nom"   :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="U-TH-3" name="email" label="Email" :$sortDirection :$sortBy/>
             @if ($showForAdminService)
              <x-sortable-th wire:key="U-TH-3" name="specialty" label="spécialité" :$sortDirection :$sortBy/>
             @endif
             <x-sortable-th wire:key="U-TH-4" name="created_at" label="date de creation" :$sortDirection :$sortBy/>
             <x-sortable-th wire:key="U-TH-4" name="tel" label="télephone" :$sortDirection :$sortBy/>
             <th scope="column"><div>actions</div></th>
             </tr>
          </thead>
          <tbody>
           @if ($showForAdminService)
            @foreach ($this->users as $u)
             <tr wire:key="{{ $u->id }}" >
             <td scope="row">{{ $u->name}}</td>
             <td>{{ $u->email}}</td>
             <td>{{ $u->specialty}}</td>
            <td>{{ $u->created_at->format('d/m/Y')}}</td>
            <td>{{ $u->personnelInfo?->tel}}</td>
            <td>
            <livewire:open-modal-button wire:key="'o-b-u-'.{{ $u->id }}"
            classes="rounded"
            content="<i class='fa-solid fa-pen-to-square'></i>"
            :data='[
                     "title" => "Mettre à jour l utilisateur",
                    "component" => [
                                   "name" => "user-modal",
                                   "parameters" => ["id"=>$u->id]
                                   ]
                   ]'
            />
           </td>
           </tr>
           @endforeach
    @else
        @if ($showForSuperAdmin)

             @foreach ($this->users as $u)
             <tr wire:key="{{ $u->id }}" scope="row">
             <td>{{ $u->name}}</td>
             <td>{{ $u->email}}</td>
             <td>{{ $u->created_at->format('d/m/Y')}}</td>
            <td>{{ $u->tel}}</td>
            <td>
            <livewire:open-dialog-button wire:key="'o-d-u-'.{{ $u->id }}" classes="rounded"
                content="<i class='fa-solid fa-trash'></i>"
                :data='[
                         "question" => "supprimer l utilisateur",
                         "details" =>"Etes-vous sûr que vous voulez supprimer  $u->name ?",
                         "actionEvent"=>[
                                         "event"=>"delete-user",
                                         "parameters"=>$u
                                         ]
                         ]'
                 />
           <livewire:open-modal-button wire:key="'o-b-u-'.{{ $u->id }}" classes="rounded"
            content="<i class='fa-solid fa-pen-to-square'></i>"
            :data='[
                    "title" => "Mettre à jour l utilisateur",
                     "component" => [
                                     "name" => "user-modal",
                                     "parameters" => ["id"=>$u->id]
                                     ]
                    ]'
             />
             <livewire:open-modal-button wire:key="'o-b-m-u-'.{{ $u->id }}" classes="rounded"
                 content="<i class='fa-solid fa-link'></i>"
                 :data='[
                         "title" => "gérer les rôles",
                         "component" => [
                                         "name" => "admin.manage-roles-modal",
                                         "parameters" => ["id" => $u->id]
                                         ]
                         ]'
              />
            </td>
         </tr>
       @endforeach
       @else
         @foreach ($this->users as $u)
        <tr wire:key="{{ $u->id }}" scope="row">
        <td>{{ $u->name}}</td>
        <td>{{ $u->email}}</td>
        <td>{{ $u->created_at->format('d/m/Y')}}</td>
        <td>{{ $u->personnelInfo?->tel}}</td>
        <td>
         <livewire:open-modal-button wire:key="'o-b-u-'.{{ $u->id }}" classes="rounded"
         content="<i class='fa-solid fa-pen-to-square'></i>"
         :data='[
                "title" => "Mettre à jour l utilisateur",
                "component" => [
                                "name" => "user-modal",
                                "parameters" => ["id"=>$u->id]
                                ]
                ]'/>
        </td>
        </tr>
       @endforeach
     @endif
@endif

        </tbody>
    </table>
    <div class="table__footer">
        {{-- {{ $this->establishments->links() }} --}}
    </div>
    @else
    <div class="table__footer">
        <h2>
            {{ $noUserFoundMessage }}
        </h2>
    </div>
   @endif
</div>



