$(document).ready(function () {
    $(".stickyside").stick_in_parent({
        offset_top: 150
    });
    $('.stickyside a').click(function () {
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 150
        }, 500);
        return false;
    });

    var lastId,
        topMenu = $(".stickyside"),
        topMenuHeight = topMenu.outerHeight(),
        menuItems = topMenu.find("a"),
        scrollItems = menuItems.map(function () {
            var item = $($(this).attr("href"));
            if (item.length) {
                return item;
            }
        });

    $(window).scroll(function () {
        var fromTop = $(this).scrollTop() + topMenuHeight - 50;
        var cur = scrollItems.map(function () {
            if ($(this).offset().top < fromTop)
                return this;
        });

        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;

            menuItems
                .removeClass("active")
                .filter("[href='#" + id + "']").addClass("active");
        }
    });

});