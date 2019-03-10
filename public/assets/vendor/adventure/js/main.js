
$(document).ready(function(){
	"use strict";

  //-------- Active Sticky Js ----------//
  $(".default-header").sticky({topSpacing:0});


    $('.active-works-carousel').owlCarousel({
        items:1,
        loop:true,
        margin: 100,
        dots: true,
        autoplay:true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1,
            },
            768: {
                items: 1,
            }
        }
    });

    $('.active-gallery').owlCarousel({
        items:1,
        loop:true,
        dots: true,
        autoplay:true,
        nav:true,
        navText: ["<span class='lnr lnr-arrow-up'></span>",
        "<span class='lnr lnr-arrow-down'></span>"],
            responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1,
            },
            768: {
                items: 2,
            },
            900: {
                items: 6,
            }

        }
    });

$('.active-blog-slider').owlCarousel({
        loop: true,
        dots: true,
        items: 1,
        autoplay: true,
        autoplayTimeout: 3500,
        smartSpeed: 1000,
        animateOut: 'fadeOut',
      })
 });
