@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        :title="__('pages.users.add-super-admin-btn-txt')"
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

