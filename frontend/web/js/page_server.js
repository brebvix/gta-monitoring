$(document).ready(function() {
    $('#serverbuybackgroundform-background').on('change', function() {
        $('#table-result').removeAttr('class');
        $('#table-result').addClass($(this).val());
        //$('#table-result').addClass('text-light');
        $('.text-color').each(function() {
            $(this).addClass('text-light');
            $(this).removeClass('text-muted');
        });
        //$('#table-result').find('a').addClass('text-light');
    });

    $('#serverbuybackgroundform-days').on('change keyup input click', function () {
        if (this.value.match(/[^0-9.]/g)) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        }

        $('#resultAmount').text($(this).val() * 5);
    });

    $('#serverbuytopform-days').on('change keyup input click', function () {
        if (this.value.match(/[^0-9.]/g)) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        }

        $('#topResultAmount').text($(this).val() * 5);
    });
});