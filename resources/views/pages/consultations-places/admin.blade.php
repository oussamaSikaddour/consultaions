@extends('layouts.userLayout')
@section('pageContent')
<section class="section">
    <livewire:rendezvous-table  :consultationPlaceId="$id" :showMoreDetails="true"/>
  <div>
</section>
@endsection
