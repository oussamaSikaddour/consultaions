@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        title="Ajouter Un lieu de consultation"
        classes="button--primary"
        content="<i class='fa-solid fa-hospital'></i>"
        :data="$modalData"
    />
     </div>


     <livewire:establishment.consultations-places-table
     lazy
      />
     <livewire:users-table
     lazy
     noUserFoundMessage="Aucun administrateur trouvé pour le lieu de consultation sélectionné pour le moment"
     userableType="admin_place_of_consultation"
     />
  <div>

  </section>
@endsection
