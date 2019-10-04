$(document).ready(function () {
    var min_slots = $('#min_slots').text(),
        max_slots = $('#max_slots').text(),
        basePrice = $('#price_per_slot').text(),
        months = $('#monthTitle').text(),
        slots = $('#slotsTitle').text();

    calculate();

    $("#range_months").ionRangeSlider({
        grid: true,
        min: 1,
        max: 12,
        from: 1,
        prefix: $('#months_text').text() + ": ",
        max_postfix: "",
        onChange: function (value) {
            $('#monthTitle').text(value.from);
            $('#hostingfinalorderform-months').val(value.from);
            months = value.from;
            calculate();
        }
    });

    $("#range_slots").ionRangeSlider({
        grid: true,
        min: min_slots,
        max: max_slots,
        from: min_slots,
        prefix: $('#slots_text').text() + ": ",
        max_postfix: "",
        onChange: function (value) {
            $('#slotsTitle').text(value.from);
            $('#hostingfinalorderform-slots').val(value.from);
            slots = value.from;
            calculate();
        }
    });

    function calculate() {
        var pricePerMonth = parseFloat(basePrice) * parseFloat(slots);
        var price = parseFloat(months) * pricePerMonth;

        $('#resultPrice').text(price);
    }
});