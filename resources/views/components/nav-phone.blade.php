

@auth
    @php
    $userDropdownLink = auth()->user()->name . ' <i class="fa-solid fa-user"></i>';
    $adminDropdownLink ='parametre globale <i class="fa-solid fa-gears"></i>';
    @endphp
<nav class="nav--phone" aria-labelledby="main-nav-phone">
    <h2 id="main-nav-phone" class="sr-only">
        Main navigation
    </h2>
        <ol class="nav__items">
            <x-nav-link
                   route="homePage"
                   :label="__('nav.accueil')"
              />
            <x-nav-link
                    route="home"
                    :label="__('nav.rendez-vous')"
            />
         @can('admin-access')
             <x-nav-link
                     route="dashboard"
                     :label="__('nav.dashboard')"
             />
         @endcan
         @can('admin-establishment-access')
             <x-nav-link
                     route="establishment"
                     :label="__('nav.establishment')"
               />

             <x-nav-link
                     route="places-of-consultations"
                     :label="__('nav.consultationsPlaces')"
                />
          @endcan
         @can('admin-service-access')
            <x-nav-link
                     route="doctors"
                     :label="__('nav.doctors')"
            />
            <x-nav-link
                     route="service"
                     :label="__('nav.services')"
            />
          @endcan
         @can('admin-place-of-consultation-access')
              <x-nav-link
                     route="place-of-consultation"
                    :label="__('nav.consultationPlace')"
              />
          @endcan
         @can('doctor-access')
               <x-nav-link
                       route="doctor"
                       :label="__('nav.doctor')"
                />
          @endcan

          @can('admin-access')
          <x-dropdown-nav-link
                     :items="[
                               [
                                 'route' => route('users'),
                                  'label' => __('nav.users')],
                              ]"
                     :dropdownLink="$adminDropdownLink">
          </x-dropdown-nav-link>
        @endcan
                <x-dropdown-nav-link
                            :items="[
                                     [
                                        'route' => route('changePassword'),
                                        'label' => __('nav.changePassword')
                                    ],
                                    [
                                        'route'=>route('logout'),
                                        'label'=>__('nav.logout'),
                                        'icon'=>'logout'

                                    ]
                                   ]"
                        :dropdownLink="$userDropdownLink"/>
        </ol>
</nav>
@endauth
@guest
   <nav class="nav--phone" aria-labelledby="main-nav-phone">
    <h2 id="main-nav-phone" class="sr-only">
        Main navigation
    </h2>
        <ol class="nav__items">
            <x-nav-link
                  route="homePage"
                  :label="__('nav.accueil')"
             />
            <x-nav-link
                   route="loginPage"
                   :label="__('nav.login')"
             />
            <x-nav-link
                    route="registerPage"
                    :label="__('nav.register')"
            />
        </ol>
    </nav>
@endguest

