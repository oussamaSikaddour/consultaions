@extends('layouts.userLayout')
@section('pageContent')
<section class="section">
     <livewire:user.medicals-files-table
      lazy
     :showForDoctor="true" :doctorId="$userId"/>
     <livewire:rendezvous-table
      lazy
     :doctorId="$userId"
     :showForDoctor="true"/>
  </section>
@endsection
