@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        title="Ajouter Un medecin"
        classes="button--primary"
        content="<i class='fa-solid fa-users'></i>"
        :data="$modalData"
    />
     </div>


     <livewire:users-table
      lazy
      noUserFoundMessage="Aucun médecin trouvé pour le moment"
      userableType="doctor"
      :showForAdminService="true"
      :userableId="$establishmentId"
      />
  <div>

  </section>
@endsection

