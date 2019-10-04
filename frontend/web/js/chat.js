/*jslint browser: true*/
/*global $, jQuery, alert*/

$(function () {

    "use strict";

    $('.chat-left-inner > .chatonline').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        color: '#dcdcdc'

    });
    $('.chat-list').slimScroll({
        position: 'right'
        , size: "5px"
        , height: '100%'
        , color: '#dcdcdc',
        start: 'bottom'
    });

    $(document).on('ready pjax:end', function () {
        $('.chat-list').slimScroll();

        var topOffset = 445;
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;

        $('.slimScrollDiv').css('height', (height) + 'px');
        $('.chat-list ').css('height', (height) + 'px');

        setTimeout(function () {
            var bottomCoord = $('.chat-list')[0].scrollHeight;
            $('.chat-list').slimScroll({scrollTo: bottomCoord});
            $('.slimScrollBar').css('top', '343px');
            $('body, html').scrollTop($(document).height());
        }, 200);
    });

    var cht = function () {
        var topOffset = 445;
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        $(".chat-list").css("height", (height) + "px");

        setTimeout(function () {
            if ($('.chat-list').length > 0) {
                var bottomCoord = $('.chat-list')[0].scrollHeight;
                $('.chat-list').slimScroll({scrollTo: bottomCoord});
                $('.slimScrollBar').css('top', '343px');
                $('body, html').scrollTop($(document).height());
            }
        }, 200);
    };
    $(window).ready(cht);
    $(window).on("resize", cht);


    // this is for the left-aside-fix in content area with scroll
    var chtin = function () {
        var topOffset = 270;
        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        $(".chat-left-inner").css("height", (height) + "px");
    };
    $(window).ready(chtin);
    $(window).on("resize", chtin);


    $(".open-panel").on("click", function () {
        $(".chat-left-aside").toggleClass("open-pnl");
        $(".open-panel i").toggleClass("ti-angle-left");
    });

});
