@extends('layouts.userLayout')
@section('pageContent')
<section class="section">
    <livewire:rendezvous-table
    :consultationPlaceId="$id"
    :showForCPlaceAdmin="true"/>
  <div>
</section>
@endsection
