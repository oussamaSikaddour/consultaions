@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        :title="__('pages.establishment.add-service-btn-txt')"
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
     :customNoUserFoundMessage="__('pages.establishment.coord-not-fount-txt')"
     userableType="admin_service"
     userableId="unkonwn"
     />
  <div>

  </section>
@endsection
