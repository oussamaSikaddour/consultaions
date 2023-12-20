@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        title="Ajouter Un administrateur"
        classes="button--primary"
        content="<i class='fa-solid fa-users'></i>"
        :data="$modalData"
    />
     </div>


     <livewire:users-table
     :showForSuperAdmin="true"
      lazy
      />
  <div>

  </section>
@endsection

