$(window).on('load', function () {
    $('.docs-content ul li a,#aside-menu .aside-contents a').on('click', function (e) {
        let href = $(this).attr('href');
        let name = href.substr(1, href.length);
        let target = $('a[name="' + name + '"]');

        if (target.length > 0) {
            $('html, body').animate({scrollTop: (target.offset().top - 70) + 'px'}, 1000, 'swing');
        }
    });
    $('.anchor').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: ($($(this)).offset().top - 70) + 'px'}, 1000, 'swing');
    });

    $('#back-to-top').on('click', function () {
        $('body,html').animate({
            scrollTop: 0
        }, 600);
    });

    $(window).on('scroll', function () {
        let wScroll = $(this).scrollTop();

        // Back To Top Appear
        wScroll > 300 ? $('#back-to-top').fadeIn() : $('#back-to-top').fadeOut();
    });


    let $sidebar = $('.sidebar .sidebar-nav');
    $sidebar.on('scroll', function () {
        let wScroll = $(this).scrollTop();
            if(!window.localStorage){
                return false;
            }
            //로컬스토리지 저장하는 3가지 방법. 다 같은 방법.
            localStorage.setItem("scroll-position", wScroll);
    });

    if(window.localStorage){
        let wScroll = localStorage.getItem("scroll-position")
        if(wScroll)
            $sidebar.scrollTop(wScroll);
    }



    let $body = $("body");
    $(".navbar-toggler").on('click', function () {
        $.cookie('navbar-toggle', $body.hasClass('sidebar-lg-show'), {path: '/'});
    });

    $(".aside-menu-toggler").on('click', function () {
        $.cookie('aside-toggle', $body.hasClass('aside-menu-lg-show'), {path: '/'});
    });

    anchors.add();

    $("#show-eng-docs").on('click', function () {
        $('#kr-article').parent().toggleClass('col-lg-12').toggleClass('col-lg-6');
        $('#en-article').parent().fadeToggle()
    });
    $('[data-toggle="tooltip"]').tooltip("show");

    $("#banner-slide").owlCarousel({
        autoplay: 2000,
        loop: true,
        items: 1,
        pagination: false,
    });

});
