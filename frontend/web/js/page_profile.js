$(document).ready(function() {
    $('.user-avatar').on('click', function() {
        $('#avataruploadform-avatar').click();

        $('#avataruploadform-avatar').on('change', function() {
            $(this).parent().parent().parent().find('form').submit();
        });
    });

    $('#telegramCheckbox').on('change', function () {
        pathname = window.location.pathname;

        if (pathname[1] == 'e' && pathname[2] == 'n') {
            window.location = '/en/user/telegram-change';
        } else {
            window.location = '/user/telegram-change';
        }
    });
});