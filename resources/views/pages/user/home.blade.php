@extends('layouts.userLayout')
@section('pageContent')
<section class="section">
    <div>
        <livewire:open-modal-button
        :title="__('pages.rendez-vous.add-btn-txt')"
        classes="button--primary"
        content="<i class='fa-solid fa-folder-open'></i>"
        :data="$modalData"/>
     </div>

     <livewire:user.medicals-files-table
     :$openedBy
     lazy
     />
     <livewire:rendezvous-table
     :$openedBy
     lazy
     />


  </section>
@endsection
