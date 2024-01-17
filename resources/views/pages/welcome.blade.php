@extends("layouts.guestLayout")
@section("pageContent")
<section class="hero">
    <div class="hero__overLay">

      <div class="hero__card">
        <div class="hero__card__logo"><img src="./img/med.png" alt="log"></div>
        <div class="hero__card__header">
          @lang("pages.landing.main-title")
        </div>
        <div class="hero__card__content">
          <p>
            @lang("pages.landing.welcome-text")
          </p>


          @auth
          <a class="hero__card__action" aria-current="register"
          href="{{ route("home") }}"
          >
          <span><i class="fa-solid fa-arrow-right"></i></span> @lang("pages.landing.text-button-auth")</a>
          @endauth
          @guest
          <a class="hero__card__action" aria-current="register"
          href="{{ route("registerPage") }}"
          >
          <span><i class="fa-solid fa-arrow-right"></i></span>@lang("pages.landing.text-button-guest")</a>

          @endguest

        </div>

      </div>
    </div>

  </section>
@endsection


<script>
addEventListener("DOMContentLoaded", (event) => {
    const actionBtn= document.querySelector(".hero__card__action")?.focus();
});
</script>
