var galleryButtons = document.getElementsByClassName("galleryButton");

var viewImage = function () {

    imgUrl = this.getAttribute("data-image");
    const viewer = document.querySelector('#viewer');
    const link = viewer.querySelector('a');
    const image = viewer.querySelector('img');
    const lossy = imgUrl.replace('sd-thumbs', 'sd-lossy');
    const orig = imgUrl.replace('sd-thumbs', 'sd-img').replace('.jpg', '.png');
    image.src = lossy;
    link.href = orig;
};

Array.from(galleryButtons).forEach(function (galleryButton) {
    galleryButton.addEventListener('click', viewImage);
});
