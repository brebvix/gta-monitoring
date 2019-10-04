$(document).ready(function() {
    $('.payment-amount').on('change keyup input click', function () {
        if (this.value.match(/[^0-9.]/g)) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        }

        if (parseFloat($(this).val()) > 50) {
            $(this).parent().find('.payment-result-amount').text(Big(parseFloat($(this).val()) * 1.1).toFixed(2));
        } else {
            $(this).parent().find('.payment-result-amount').text($(this).val());
        }
    });
});