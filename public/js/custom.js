// document.addEventListener('livewire:initialized', () => {
//     Livewire.on('refresh-page-after-timeout', () => {
//         // Set a 30-second (30000 milliseconds) timeout before refreshing the page
//         setTimeout(() => {
//             location.reload(); // Refresh the page
//         }, 30000);
//     });
// });

///////////////////////////////////////////////////////////////////////////////////////////////////////                                                                                               Nav
/////////////////////////////////////////////////////////////////////////////////////////////////////



const navBtns = document.querySelectorAll(".nav__btn");

const toggleNavVisibility = (btn, className) => {
  const subItems = btn.nextElementSibling;
  if (subItems) {
    const expanded = btn.classList.contains(className);
    btn.setAttribute("aria-expanded", expanded);
    btn.setAttribute("aria-hidden", !expanded);
    subItems.toggleAttribute("hidden", !expanded);
  }
};

navBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    navBtns.forEach(b => {
      if (b !== btn) {
        b.classList.remove("clicked");
        b.parentElement.classList.remove("clicked");
        toggleNavVisibility(b, 'clicked');
      }
    });
    btn.classList.toggle("clicked");
    btn.parentElement.classList.toggle("clicked");
    toggleNavVisibility(btn, "clicked");
  });
});



const HumBtn = document.querySelector(".nav__humb");
const navPhone= document.querySelector(".nav--phone")
HumBtn?.addEventListener('click', () => {
    HumBtn.classList.toggle("open")
    navPhone.classList.toggle("open")
  if (navPhone) {
    const expanded = HumBtn.classList.contains('open');
    HumBtn.setAttribute("aria-expanded", expanded);
    HumBtn.setAttribute("aria-hidden", !expanded);
    navPhone.toggleAttribute("hidden", !expanded);
  }
});
