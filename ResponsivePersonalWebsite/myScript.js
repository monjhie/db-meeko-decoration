// Get the button
let mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// script.js

// Get the audio element and mute button
const audio = document.getElementById('audio');
const muteButton = document.getElementById('mute-btn');

// Initially mute the audio and set the audio to not play
audio.muted = true;
audio.pause();

// Function to toggle mute/unmute and play the audio
function toggleMute() {
    if (audio.muted) {
        // Unmute and play the audio
        audio.muted = false;
        audio.play();
        muteButton.innerHTML = '<i class="fa-solid fa-volume-high"></i>';
    } else {
        // Mute the audio
        audio.muted = true;
        audio.pause();
        muteButton.innerHTML = '<i class="fa-solid fa-volume-xmark"></i>';
    }
}

ScrollReveal().reveal('.fade-in', {
  origin: 'bottom',
  distance: '20px',
  duration: 600,
  opacity: 0,
  reset: false // Animation only runs once
});

document.querySelector('a[href^="#"]').addEventListener('click', function (e) {
  e.preventDefault();
  const targetId = this.getAttribute('href');
  const targetElement = document.querySelector(targetId);
  if (targetElement) {
      targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
});




