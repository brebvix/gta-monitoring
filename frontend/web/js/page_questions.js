$(document).ready(function() {
    $('.card-question').on('click', function() {
        window.location = $(this).attr('data-href');
    });
});