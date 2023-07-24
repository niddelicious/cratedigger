var galleryButtons = document.getElementsByClassName("galleryButton");

var viewImage = function () {

    imgUrl = this.getAttribute("data-image");
    const viewer = document.querySelector('#viewer');
    const link = viewer.querySelector('a');
    const image = viewer.querySelector('img');
    const newSrc = imgUrl.replace('sd-thumbs', 'sd-img').replace('.jpg', '.png');
    image.src = newSrc;
    link.href = newSrc;
};

Array.from(galleryButtons).forEach(function (galleryButton) {
    galleryButton.addEventListener('click', viewImage);
});
