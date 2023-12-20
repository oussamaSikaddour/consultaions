@extends('layouts.userLayout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        title="Ajouter Un planning"
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
     />

  <div>

  </section>
@endsection
