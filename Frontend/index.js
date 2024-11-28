let currentSlide = 0;

function moveSlide(direction) {
    const images = document.querySelectorAll('.carousel-images .card-image');
    images[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + direction + images.length) % images.length;
    images[currentSlide].classList.add('active');
}