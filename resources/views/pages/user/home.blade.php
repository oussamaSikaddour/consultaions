@extends('layouts.userLayout')
@section('pageContent')
<section class="section">
    <div>
        <livewire:open-modal-button
        title="Ajouter Un Dossier médical"
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
