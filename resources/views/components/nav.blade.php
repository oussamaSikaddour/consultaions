



@auth
    @php
    $userDropdownLink = auth()->user()->name . ' <i class="fa-solid fa-user"></i>';
    $adminDropdownLink = '<i class="fa-solid fa-gears"></i>';
    @endphp


<header class="header" >
<nav class="nav" aria-labelledby="main-nav">
    <h2 id="main-nav" class="sr-only">
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
        </ol>
        <ol class="nav__items">
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

          @can('admin-access')
                  <x-dropdown-nav-link
                               :items="[
                                        [
                                          'route' => route('users'),
                                           'label' => __('nav.users')],
                                        ]"
                               :dropdownLink="$adminDropdownLink"
                    >

                 </x-dropdown-nav-link>

          @endcan
        </ol>
    </nav>
</header>
@endauth

 @guest
<header class="header" >
<nav class="nav" aria-labelledby="main-nav">
    <h2 id="main-nav" class="sr-only">
        Main navigation
    </h2>

         <ol class="nav__items">
                <x-nav-link
                        route="homePage"
                        :label="__('nav.accueil')"
                 />
          </ol>

        <ol class="nav__items">
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
</header>

@endguest

