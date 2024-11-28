const slideIndices = {
    results: 0,
    gallery: 0
};

function moveSlide(sectionId, direction) {
    const carousel = document.querySelector(`#${sectionId} .carousel-images`);
    const images = carousel.querySelectorAll('.card-image');
    images[slideIndices[sectionId]].classList.remove('active');
    slideIndices[sectionId] = (slideIndices[sectionId] + direction + images.length) % images.length;
    images[slideIndices[sectionId]].classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => {
        const firstImage = carousel.querySelector('.card-image');
        if (firstImage) {
            firstImage.classList.add('active');
        }
    });
});
