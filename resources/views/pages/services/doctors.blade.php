@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        :title="__('pages.doctors.add-d-btn-txt')"
        classes="button--primary"
        content="<i class='fa-solid fa-users'></i>"
        :data="$modalData"
    />
     </div>


     <livewire:users-table
      lazy
      :customNoUserFoundMessage="__('pages.doctors.no-d-found-txt')"
      userableType="doctor"
      :showForAdminService="true"
      :userableId="$establishmentId"
      />
  <div>

  </section>
@endsection

