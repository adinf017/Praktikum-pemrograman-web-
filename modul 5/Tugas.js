$(document).ready(function () {
    // 1. Fade-in effect for gallery images
    $('.gallery img').each(function (index) {
        $(this).delay(200 * index).fadeIn(500);
    });

    // 2. Show image in modal on click
    $('.gallery img').click(function () {
        const src = $(this).attr('src');
        $('.modal img').attr('src', src);
        $('.modal').fadeIn();
    });

    // 3. Close modal on button click or outside modal
    $('.modal .close-btn, .modal').click(function (e) {
        if (e.target !== this) return; // Prevent closing when clicking the image
        $('.modal').fadeOut();
    });
});
