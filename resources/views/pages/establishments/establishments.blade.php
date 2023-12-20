@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        title="Ajouter Un Service"
        classes="button--primary"
        content="<i class='fa-solid fa-hospital'></i>"
        :data="$modalData"
    />
     </div>


     <livewire:establishment.services-table
     lazy
     :establishmentId="$id"  />
     <livewire:users-table
     lazy
     noUserFoundMessage="Aucun  coordinateur trouvé pour le service sélectionné pour le moment"
     userableType="admin_service"
     userableId="unkonwn"
     />
  <div>

  </section>
@endsection
