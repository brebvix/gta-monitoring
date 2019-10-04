$(document).ready(function() {
    var lastClass = '';
    var lastTextClass = '';
    $('.set_background').on('change input select', function() {
        lastClass = $(this).val();
        $('#resultLink').removeAttr('class');
        $('#resultLink').attr('class', 'list-group-item');
        $('#resultLink').addClass($(this).val());
        $('#resultLink').addClass(lastTextClass);
    })

    $('.set_text_color').on('change input select', function() {
        lastTextClass = $(this).val();
        $('#resultLink').removeAttr('class');
        $('#resultLink').attr('class', 'list-group-item');
        $('#resultLink').addClass($(this).val());
        $('#resultLink').addClass(lastClass);
    });

    $('#linkbuyform-days').on('change keyup input click', function () {
        if (this.value.match(/[^0-9.]/g)) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        }

        price = parseInt($(this).val() * 20);

        if (isNaN(price)) {
            price = 0;
        }
        $('#resultAmount').text(price);
    });

    $('#linkbuyform-title').on('change keyup input click', function () {
        if ($(this).val().length > 0) {
            $('#resultLink').text($(this).val());
        }
    });
});