/* This JavaScript file consist of the animations for the UI on the login page/file (e.g Scroll Up, title and divs).
*/

//singco welcome text animation 
const element = document.querySelector("#element");
const startTime = Date.now();
const duration = 700;
const letters = element.dataset.text.split("");
const steps = letters.length;
const map = (n, x1, y1, x2, y2) => Math.min(Math.max(((n - x1) * (y2 - x2)) / (y1 - x1) + x2, x2), y2);
const random = (set) => set[Math.floor(Math.random() * set.length)];
let frame;
(function animate() {
  frame = requestAnimationFrame(animate);
  const step = Math.round(map(Date.now() - startTime, 0, duration, 0, steps));
  element.innerText = letters
  .map((s, i) => (step - 1 >= i ? letters[i] : random("108-0#<=*+>")))
  .join("");
  if (step >= steps) {
  cancelAnimationFrame(frame);
  }
})();

feather.replace();

//scroll up animation
mybutton = document.getElementById("scroll_top");
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

//hamburger menu in mobile version
const hamburger = document.querySelector(".hamburger");
const navLinks = document.querySelector(".nav-links");
const links = document.querySelectorAll(".nav-links li");

hamburger.addEventListener("click", () => {
  navLinks.classList.toggle("open");
  document.body.classList.toggle("removescroll");
  links.forEach(link => {
    link.classList.toggle("fade");
  });
});

function remove(){
  navLinks.classList.remove("open");
  document.body.classList.remove("removescroll");
  links.forEach(link => {
    link.classList.toggle("fade");
  });
}

//Lazy Scroll
document.addEventListener("DOMContentLoaded", function(event) {
    document.addEventListener("scroll", function(event) {
        const animatedBoxes = document.querySelectorAll(".card_1, .card_2, .card_3, .svg");
        const windowOffsetTop = window.innerHeight + window.scrollY-100;

        Array.prototype.forEach.call(animatedBoxes, (animatedBox) => {
            const animatedBoxOffsetTop = animatedBox.offsetTop;
            if (windowOffsetTop >= animatedBoxOffsetTop) {
                addClass(animatedBox, "fade-in");
            }
        });
    });
});

function addClass(element, className) {
    const arrayClasses = element.className.split(" ");
    if (arrayClasses.indexOf(className) === -1) {
        element.className += " " + className;
    }
}

//modal
  const modal = document.querySelector(".modal");
  const trigger = document.querySelector("#login");
  const closeButton = document.querySelector(".close-button");

  function toggleModal() {
      modal.classList.toggle("show-modal");
  }

  function windowOnClick(event) {
      if (event.target === modal) {
          toggleModal();
      }
  }

  trigger.addEventListener("click", toggleModal);
  closeButton.addEventListener("click", toggleModal);
  window.addEventListener("click", windowOnClick);

//stop resubmission
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
