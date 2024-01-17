@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        :title="__('pages.consultation-places.add-cp-btn-txt')"
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
     :customNoUserFoundMessage="__('pages.consultation-places.no-cp-agent-found-txt')"
     userableType="admin_place_of_consultation"
     />
  <div>

  </section>
@endsection
