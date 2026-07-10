AOS.init({
    duration: 600, // Animation duration in ms
  });

window.addEventListener('hashchange', () => {
    AOS.refresh(); // For AOS
});
