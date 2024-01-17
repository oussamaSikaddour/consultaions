@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        :title="__('pages.dashboard.add-establishment-btn-text')"
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
     :noUserFoundMessage="__('pages.dashboard.no-user-found-message')"
     userableType="admin_establishment"
     />
  <div>

  </section>
@endsection




