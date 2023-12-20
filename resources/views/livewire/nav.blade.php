
@php

    if(session()->has("maintenanceIsActive")){
        dd(session("maintenanceIsActive"));
    }
@endphp

@auth
    @php
    $userDropdownLink = auth()->user()->name . ' <i class="fa-solid fa-user"></i>';
    $adminDropdownLink = $forPhone ?'parametre globale <i class="fa-solid fa-gears"></i>'
                                    :'<i class="fa-solid fa-gears"></i>';
    @endphp
@if($forPhone)

  <nav class="nav--phone" aria-labelledby="main-nav-phone">
    <h2 id="main-nav-phone" class="sr-only">
        Main navigation
    </h2>
        <ol class="nav__items">

        <x-nav-link route="homePage" label="Accueil"/>
        <x-nav-link route="home" label="Mes rendez-vous"/>
         @can('admin-access')
          <x-nav-link route="dashboard" label="Tableau de bord"/>
          @endcan
         @can('admin-establishment-access')
          <x-nav-link route="establishments" :parameter="session('establishment_id')" label="Établissement"/>
          <x-nav-link route="places-of-consultations"  label="Lieux de consultations"/>
          @endcan
         @can('admin-service-access')
          <x-nav-link route="doctors" :parameter="session('establishment_id')" label="Médecins"/>
          <x-nav-link route="service" :parameter="session('service_id')"  label="Service"/>
          @endcan
         @can('admin-place-of-consultation-access')
          <x-nav-link route="place-of-consultation" :parameter="session('consultation_place_id')" label="Lieu de consultation"/>
          @endcan
         @can('doctor-access')
          <x-nav-link route="doctor" label="Médecin"/>
          @endcan
          <x-dropdown-nav-link :items="[
            ['route' => route('changePassword'), 'label' => 'Changer le mot de passe'],
               ]"
                 :dropdownLink="$userDropdownLink">
             <li wire:click="logout">
             Se déconnecter <i class="fa-solid fa-right-from-bracket"></i>
             </li>
          </x-dropdown-nav-link>

          @can('admin-access')
          <x-dropdown-nav-link :items="[
                  ['route' => route('users'), 'label' => 'Gérer les utilisateurs'],
                  ['route' => route('siteParameters'), 'label' => 'paramètres du site'],
               ]"
            :dropdownLink="$adminDropdownLink">
           </x-dropdown-nav-link>
          @endcan
        </ol>
</nav>

@else

<header class="header" >
<nav class="nav" aria-labelledby="main-nav">
    <h2 id="main-nav" class="sr-only">
        Main navigation
    </h2>

        <ol class="nav__items">
            <x-nav-link route="homePage" label="Accueil"/>
            <x-nav-link route="home" label="Mes rendez-vous"/>
        </ol>
        <ol class="nav__items">
         @can('admin-access')
          <x-nav-link route="dashboard" label="Tableau de bord"/>
          @endcan
         @can('admin-establishment-access')
          <x-nav-link route="establishments" :parameter="session('establishment_id')" label="Établissement"/>
          <x-nav-link route="places-of-consultations"  label="Lieux de consultations"/>
          @endcan
         @can('admin-service-access')
          <x-nav-link route="doctors" :parameter="session('establishment_id')" label="Médecins"/>
          <x-nav-link route="service" :parameter="session('service_id')"  label="Service"/>
          @endcan
         @can('admin-place-of-consultation-access')
          <x-nav-link route="place-of-consultation" :parameter="session('consultation_place_id')" label="Lieu de consultation"/>
          @endcan
         @can('doctor-access')
          <x-nav-link route="doctor" label="Médecin"/>
          @endcan
          <x-dropdown-nav-link :items="[
            ['route' => route('changePassword'), 'label' => 'Changer le mot de passe'],
               ]"
                 :dropdownLink="$userDropdownLink">
             <li wire:click="logout">
             Se déconnecter <i class="fa-solid fa-right-from-bracket"></i>
             </li>
          </x-dropdown-nav-link>

          @can('admin-access')
          <x-dropdown-nav-link :items="[
            ['route' => route('users'), 'label' => 'Gérer les utilisateurs'],
            ['route' => route('siteParameters'), 'label' => 'paramètres du site'],
               ]"
            :dropdownLink="$adminDropdownLink">

           </x-dropdown-nav-link>


          @endcan
        </ol>
    </nav>
</header>
@endif
@endauth

@guest


@if($forPhone)
   <nav class="nav--phone" aria-labelledby="main-nav-phone">
    <h2 id="main-nav-phone" class="sr-only">
        Main navigation
    </h2>
        <ol class="nav__items">
            <x-nav-link route="homePage" label="Accueil"/>
            <x-nav-link route="loginPage" label="Se connecter"/>
            <x-nav-link route="registerPage" label="S'inscrire"/>
        </ol>
    </nav>
@else

<header class="header" >
<nav class="nav" aria-labelledby="main-nav">
    <h2 id="main-nav" class="sr-only">
        Main navigation
    </h2>

         <ol class="nav__items">
                <x-nav-link route="homePage" label="Accueil"/>
          </ol>

        <ol class="nav__items">
            <x-nav-link route="loginPage" label="Se connecter"/>
            <x-nav-link route="registerPage" label="S'inscrire"/>
        </ol>
    </nav>
</header>
@endif
@endguest






