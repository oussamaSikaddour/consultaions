@extends("layouts.guestLayout")
@section("pageContent")
<section class="hero">
    <div class="hero__overLay">

      <div class="hero__card">
        <div class="hero__card__logo"><img src="./img/med.png" alt="log"></div>
        <div class="hero__card__header">
          Des spécialistes à portée de main.
        </div>
        <div class="hero__card__content">
          <p>
            Réservez facilement vos consultations avec des spécialistes via notre plateforme. Simplifiez votre accès aux soins et bénéficiez d'un parcours médical fluide et efficace. Votre santé mérite une expérience simplifiée et sans tracas
          </p>


          @auth
          <a class="hero__card__action" aria-current="register"
          href="{{ route("home") }}"
          >
          <span><i class="fa-solid fa-arrow-right"></i></span>Mes rendez-vous</a>
          @endauth
          @guest
          <a class="hero__card__action" aria-current="register"
          href="{{ route("registerPage") }}"
          >
          <span><i class="fa-solid fa-arrow-right"></i></span>S'inscrire </a>

          @endguest

        </div>

      </div>
    </div>

  </section>
@endsection
