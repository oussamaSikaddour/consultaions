@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        title="Ajouter Un établissement"
        classes="button--primary"
        content="<i class='fa-solid fa-hospital'></i>"
        :data="$modalData"
    />
     </div>


     <livewire:admin.establishments-table
     lazy
     />
     <livewire:users-table
     lazy
     noUserFoundMessage="Aucun administrateur trouvé pour l'établissement sélectionné pour le moment"
     userableType="admin_establishment"
     />
  <div>

  </section>
@endsection


