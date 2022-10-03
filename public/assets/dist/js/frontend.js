$(() => {
    // lazy loading images
    $("img").addClass("lazy");
    $(".lazy").Lazy({
        // your configuration goes here
        scrollDirection: "vertical",
        effect: "fadeIn",
        visibleOnly: true,
        onError: function (element) {
            console.log("error loading " + element.data("src"));
        },
    });

    // add padding to body
    $("body").css({
        paddingTop: 140,
    });

    // init scoll bar
    $("body").niceScroll({
        cursorcolor: "var(--main-color)",
        zindex: 9999,
        cursorminheight: 100,
        cursorwidth: "8px",
        autohidemode: false,
    });

    // hide loading icon
    setTimeout(() => {
        $(".loading").fadeOut(500);
    }, 500);

    // slide nav click
    $(".navbar-toggler").on("click", function () {
        $("#navbarColor01").slideToggle();
    });
    // service card hover
    $(".section-services .service-item")
        .on("mouseenter", function () {
            $before = "<div class='before'></div>";
            $(this).append($before);

            $(this).find(".before").animate(
                {
                    width: "100%",
                    height: "100%",
                },
                500
            );
        })
        .on("mouseleave", function () {
            $(this).find(".before").animate(
                {
                    width: "0",
                    height: "0",
                },
                500
            );
        });

    // slide top button
    $(".slide,.navbar-brand").on("click", function (e) {
        e.preventDefault();
        $("html,body").animate(
            {
                scrollTop: 0,
            },
            700
        );
    });

    // check scroll for nav items
    let checkScrollNavItems = function () {
        if ($(window).scrollTop()) {
            let navItems = $(".navbar-collapse")
                .find(".nav-item a")
                .not(".contact-link");

            for (let index = 0; index < navItems.length; index++) {
                const element = navItems[index];
                let dataLink = $($(element).data("scroll"));
                if (
                    $(window).scrollTop() >=
                    dataLink.offset().top - ($("nav").outerHeight() + 30)
                ) {
                    $(element)
                        .addClass("active")
                        .parent()
                        .siblings()
                        .find("a")
                        .removeClass("active");
                }
            }
        }
    };

    checkScrollNavItems();

    // check scroll top
    let checkScrollBtn = () => {
        if ($("html,body").scrollTop() < 600) {
            $(".slide-up").slideUp(500);
        } else {
            $(".slide-up").slideDown(500);
        }
    };
    checkScrollBtn();

    $(window).on("scroll", function () {
        checkScrollBtn();
        checkScrollNavItems();
    });

    // nav items click
    $(".nav-link")
        .not(".contact-link")
        .on("click", function (e) {
            e.preventDefault();
            $("html,body").animate(
                {
                    scrollTop:
                        $($(this).data("scroll")).offset().top -
                        $("nav").outerHeight(),
                },
                700
            );
        });

    // swiper plugin
    const swiper = new Swiper(".swiper", {
        // Optional parameters
        direction: "horizontal",
        effect: "coverflow",
        loop: true,
        centeredSlides: true,
        grabCursor: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        coverflowEffect: {
            rotate: 45,
            stretch: 10,
            depth: 100,
            modifier: 1,
            slideShadows: false,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        // If we need pagination
        // pagination: {
        //     el: ".swiper-pagination",
        // },

        // Navigation arrows
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            // when window width is >= 480px
            480: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            // when window width is >= 640px
            640: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            // when window width is >= 640px
            968: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            // when window width is >= 640px
            1200: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });
});
