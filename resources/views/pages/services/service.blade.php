@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        :title="__('pages.services.add-planing-btn-txt')"
        classes="button--primary"
        content="<i class='fa-solid fa-calendar-days'></i>"
        :data="$modalData"
    />
     </div>


     <livewire:service.plannings-table
     lazy
     :serviceId="$id"
     />
     <livewire:service.plannings-days-table
     lazy
     :serviceId="$id"
     :showForCoordService=true
     />

  <div>

  </section>
@endsection
