define([
    'jquery',
    'CustomHomePage_CarouselWidget/js/carousel/owl.carousel.min',
    'CustomHomePage_CarouselWidget/js/carousel/slick.min'
], function ($) {
    'use strict';

    $('#owl-carousel-mainbanner').owlCarousel({
        loop: true,
        items: 1, 
        nav: true,
        autoplay:false,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        dots: false,
        navText : ["<i class='fas fa-chevron-left'></i>","<i class='fas fa-chevron-right'></i>"]

    });
    $('.owl-carousel').owlCarousel({
        loop: true,
        items: 5, 
        nav: true,
        autoplay:false,
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        dots: true,
        navText : ["<i class='fas fa-chevron-left'></i>","<i class='fas fa-chevron-right'></i>"],
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [900,3], // betweem 900px and 601px
        itemsTablet: [700,2], // 2 items between 600 and 480
        itemsMobile : [479,1] , // 1 item between 479 and 0
        responsiveClass:true,
        responsive:{
            0:{
                items:2,
                nav:true
            },
            600:{
                items:3,
                nav:false
            },
            1000:{
                items:5,
                nav:true,
                loop:false
            }
        }
    });

    /** Related product in detail page */
    jQuery(document).ready(function () {
        jQuery("#related").slick({
            rows: 2,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: $(".prev-btn"),
            nextArrow: $(".next-btn"),
            // responsive: [
            //     {
            //         breakpoint: 1280,
            //         settings: {
            //             slidesToShow: 3,
            //             slidesToScroll: 3
            //         }
            //     },
            //     {
            //         breakpoint: 768,
            //         settings: {
            //             slidesToShow: 2,
            //             slidesToScroll: 2
            //         }
            //     },
            //     {
            //         breakpoint: 600,
            //         settings: {
            //             slidesToShow: 1,
            //             slidesToScroll: 1
            //         }
            //     }
            // ]
        });

        // Validate category banner
        $(document).ready(function () {
            var griditem = $('.grid-item');
            var griditem0 = griditem[0];
            var griditem1 = griditem[1];

            var cthome0 = griditem.find('.ct-home-banner')[0];
            var image0 = $(cthome0).children(".col-12")[0];
            var image00 = $(image0).children(".category-image")[0];

            var cthome1 = griditem.find('.ct-home-banner')[1];
            var image1 = $(cthome1).find('.thumbnail')[0]

            var cthome2 = griditem.find('.ct-home-banner')[2];
            var image2 = $(cthome2).find('.image_mobile')[0]

            console.log(image2);
            // neu hinh 0 ko co
            if(image00 === undefined) {
                $(griditem0).remove();
                $(griditem1).attr("class","grid-item col-lg-12 ct-height-x1");

            }
            // neu hinh 1 ko co
            if(image1 === undefined) {
                $(cthome1).parent().remove();
                $(cthome2).parent().attr('class','col-12 col-lg-12 col-sm-12');
                $(cthome2).parent().parent().css("flex-wrap","nowrap");
            }
            // neu hinh 2 ko co
            if(image2 === undefined) {
                $(cthome2).parent().remove();
                $(cthome1).parent().attr('class','col-12 col-lg-12 col-sm-12');
                $(cthome1).parent().parent().css("flex-wrap","nowrap");
            }
            // neu hinh 1,2 ko co
            if(image2 === undefined && image1 === undefined) {
                $(griditem1).remove();
                $(griditem0).attr('class','grid-item col-lg-12 ct-height-x1');
                $(image0).css('height','400px');
            }
        });

    });


    //list vendor
    $('.customer-logos').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [
            {
                breakpoint: 1024, // 800x600
                settings: { slidesToShow: 6 }
            },
            {
                breakpoint: 800, // 768x1024
                settings: { slidesToShow: 4 }
            },
            {
                breakpoint: 768, // 600x800
                settings: { slidesToShow: 3 }
            },
            {
                breakpoint: 600, // 480x320
                settings: { slidesToShow: 2 }
            },
            {
                breakpoint: 480, // 320x480
                settings: { slidesToShow: 2 }
            }
        ]
    });
});