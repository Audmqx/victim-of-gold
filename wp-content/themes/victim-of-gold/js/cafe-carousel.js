document.addEventListener('DOMContentLoaded', function () {
    var carousel = document.querySelector('[data-carousel]');
    if (!carousel) return;

    var track = carousel.querySelector('[data-carousel-track]');
    var dots = carousel.querySelectorAll('[data-dot]');

    function getActiveIndex() {
        return Math.round(track.scrollLeft / track.offsetWidth);
    }

    function setActiveDot(index) {
        dots.forEach(function (dot, i) {
            dot.classList.toggle('cafe-carousel__dot--active', i === index);
        });
    }

    track.addEventListener('scroll', function () {
        setActiveDot(getActiveIndex());
    }, { passive: true });

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            var index = parseInt(dot.getAttribute('data-dot'), 10);
            track.scrollTo({ left: index * track.offsetWidth, behavior: 'smooth' });
        });
    });
});
