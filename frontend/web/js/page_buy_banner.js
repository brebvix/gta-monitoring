$(document).ready(function() {
    $('#bannerbuyform-days').on('change keyup input click', function () {
        if (this.value.match(/[^0-9.]/g)) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        }

        price = parseInt($(this).val()) * parseInt($('#bannerPrice').text());

        if (isNaN(price)) {
            price = 0;
        }

        $('#resultPrice').text(price);
    });
});