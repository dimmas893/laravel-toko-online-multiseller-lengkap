var searchOpen = (function () {
    return {
        //main function to initiate the module
        init: function () {
            $(".search-box").on("click", function (e) {
                e.stopPropagation();
            });

            $(document).on("click", ".typed-search-box-shown", function (e) {
                $(this).removeClass("typed-search-box-shown");
                $(".typed-search-box").addClass("d-none");
            });
        },
    };
})();

$(function () {
    $("#category-menu-icon, #category-sidebar")
        .on("mouseover", function (event) {
            $("#hover-category-menu").show();
            $("#category-menu-icon").addClass("active");
        })
        .on("mouseout", function (event) {
            $("#hover-category-menu").hide();
            $("#category-menu-icon").removeClass("active");
        });

    $(".nav-search-box a").on("click", function (e) {
        e.preventDefault();
        $(".search-box").addClass("show");
        $('.search-box input[type="text"]').focus();
    });
    $(".search-box-back button").on("click", function () {
        $(".search-box").removeClass("show");
    });
    $("#side-filter,.filter-close").on("click", function (e) {
        e.preventDefault();
        if ($(".side-filter").hasClass("open")) {
            $(".side-filter").removeClass("open");
        } else {
            $(".side-filter").addClass("open");
        }
    });

    // if ($('.slick-slider').length > 0) {
    //     $('.slick-slider').each(function() {
    //         var $this = $(this);
    //         $this.slick({
    //             slidesToShow: 1,
    //             dots: true,
    //             prevArrow: '<button type="button" class="slick-prev"><span class="prev-icon"></span></button>',
    //             nextArrow: '<button type="button" class="slick-next"><span class="next-icon"></span></button>',
    //         });
    //     });
    // }

    /*
        Smooth scroll functionality for anchor links (animates the scroll
        rather than a sudden jump in the page)
    */
    $(".all-category-menu a").bind("click", function (e) {
        e.preventDefault(); // prevent hard jump, the default behavior

        var target = $(this).attr("href"); // Set the target as variable

        $("html, body")
            .stop()
            .animate(
                {
                    scrollTop: $(target).offset().top - 120,
                },
                600,
                function () {
                    // location.hash = target; //attach the hash (#jumptarget) to the pageurl
                }
            );

        return false;
    });

    // language flag select2
    $(".pickup-select").select2({
        templateResult: pickupInfo,
        escapeMarkup: function (m) {
            return m;
        },
    });
    function pickupInfo(state) {
        var address = $(state.element).data("address");
        var phone = $(state.element).data("phone");
        if (!address && !phone) return state.text;
        return (
            '<div class="pickup-name strong-600 heading-6 mb-2">' +
            state.text +
            '</div><div class="alpha-7 d-flex line-height-1_2 mb-2 pickup-address"><i class="la la-map-marker mr-1"></i>' +
            address +
            '</div><div class="alpha-7 d-flex line-height-1_2 pickup-number"><i class="la la-phone mr-1"></i>' +
            phone +
            "</div>"
        );
    }
    $(".pos-customer").select2({
        templateResult: posCustomerSelect,
        templateSelection: posCustomerSelect,
        escapeMarkup: function (m) {
            return m;
        },
    });
    function posCustomerSelect(state) {
        var contact = $(state.element).data("contact");
        if (!contact) return state.text;
        return (
            "<span class='d-flex justify-content-between'><span  class='flex-shrink-0'>" +
            state.text +
            "</span><span class='flex-grow-1 text-truncate ml-3 text-right'>" +
            contact +
            "</span></span>"
        );
    }
    $(document).on("click", function (e) {
        $('[data-toggle="popover"]').each(function () {
            if (
                !$(this).is(e.target) &&
                $(this).has(e.target).length === 0 &&
                $(".popover").has(e.target).length === 0
            ) {
                (
                    ($(this).popover("hide").data("bs.popover") || {})
                        .inState || {}
                ).click = false;
            }
        });
    });
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });
});

// Bootstrap selected
$(".sortSelect").each(function (index, element) {
    $(".sortSelect").select2({
        theme: "default sortSelectCustom",
    });
});
function morebrands(em) {
    if ($(em).hasClass("on")) {
        $(em).removeClass("on");
        $("#brands-collapse-box").removeClass("full");
        $(em).children("i").addClass("fa-plus").removeClass("fa-minus");
        $(em).children("span").html("More");
    } else {
        $(em).addClass("on");
        $("#brands-collapse-box").addClass("full");
        $(em).children("i").removeClass("fa-plus").addClass("fa-minus");
        $(em).children("span").html("Less");
    }
}
function sideMenuOpen(e) {
    event.preventDefault();
    $(e).find(".hamburger-icon").toggleClass("open");
    if ($(e).find(".hamburger-icon").hasClass("open")) {
        $(".side-menu-wrap,.side-menu-overlay")
            .removeClass("opacity-0")
            .addClass("opacity-1");
        $(".side-menu").removeClass("closed").addClass("open");
        $("body").addClass("side-menu-open");
    } else {
        $(".side-menu-wrap,.side-menu-overlay")
            .removeClass("opacity-1")
            .addClass("opacity-0");
        $(".side-menu").removeClass("open").addClass("closed");
        $("body").removeClass("side-menu-open");
    }
}
function sideMenuClose() {
    $(".side-menu-wrap,.side-menu-overlay")
        .removeClass("opacity-1")
        .addClass("opacity-0");
    $(".side-menu").removeClass("open").addClass("closed");
    if ($(".hamburger-icon").hasClass("open")) {
        $(".hamburger-icon").removeClass("open");
        $("body").removeClass("side-menu-open");
    }
}
function slickInit() {
    if ($(".slick-carousel").length > 0) {
        $(".slick-carousel")
            .not(".slick-initialized")
            .each(function () {
                var $this = $(this);

                var slidesRtl = false;

                var slidesPerViewXs = $this.data("slick-xs-items");
                var slidesPerViewSm = $this.data("slick-sm-items");
                var slidesPerViewMd = $this.data("slick-md-items");
                var slidesPerViewLg = $this.data("slick-lg-items");
                var slidesPerViewXl = $this.data("slick-xl-items");
                var slidesPerView = $this.data("slick-items");

                var slidesCenterMode = $this.data("slick-center");
                var slidesArrows = $this.data("slick-arrows");
                var slidesDots = $this.data("slick-dots");
                var slidesRows = $this.data("slick-rows");
                var slidesAutoplay = $this.data("slick-autoplay");

                slidesPerViewXs = !slidesPerViewXs
                    ? slidesPerView
                    : slidesPerViewXs;
                slidesPerViewSm = !slidesPerViewSm
                    ? slidesPerView
                    : slidesPerViewSm;
                slidesPerViewMd = !slidesPerViewMd
                    ? slidesPerView
                    : slidesPerViewMd;
                slidesPerViewLg = !slidesPerViewLg
                    ? slidesPerView
                    : slidesPerViewLg;
                slidesPerViewXl = !slidesPerViewXl
                    ? slidesPerView
                    : slidesPerViewXl;
                slidesPerView = !slidesPerView ? 1 : slidesPerView;
                slidesCenterMode = !slidesCenterMode ? false : slidesCenterMode;
                slidesArrows = !slidesArrows ? true : slidesArrows;
                slidesDots = !slidesDots ? false : slidesDots;
                slidesRows = !slidesRows ? 1 : slidesRows;
                slidesAutoplay = !slidesAutoplay ? false : slidesAutoplay;

                if ($("html").attr("dir") === "rtl") {
                    slidesRtl = true;
                }

                $this.slick({
                    slidesToShow: slidesPerView,
                    autoplay: slidesAutoplay,
                    dots: slidesDots,
                    arrows: slidesArrows,
                    infinite: true,
                    rtl: slidesRtl,
                    rows: slidesRows,
                    centerPadding: "0px",
                    centerMode: slidesCenterMode,
                    speed: 300,
                    prevArrow:
                        '<button type="button" class="slick-prev"><i class="la la-angle-left"></i></button>',
                    nextArrow:
                        '<button type="button" class="slick-next"><i class="la la-angle-right"></i></button>',
                    responsive: [
                        {
                            breakpoint: 1500,
                            settings: {
                                slidesToShow: slidesPerViewXl,
                            },
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: slidesPerViewLg,
                            },
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: slidesPerViewMd,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: slidesPerViewSm,
                                dots: true,
                                arrows: false,
                            },
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: slidesPerViewXs,
                                dots: true,
                                arrows: false,
                            },
                        },
                    ],
                });
            });
    }
}

$(document).ready(function () {
    searchOpen.init();
    var zoomXoffset = 20;
    var zoomposition = "right";
    if ($("html").attr("dir") === "rtl") {
        zoomXoffset = -20;
        zoomposition = "left";
    }
    $(".xzoom, .xzoom-gallery").xzoom({
        Xoffset: zoomXoffset,
        bg: true,
        tint: "#000",
        defaultScale: -1,
        position: zoomposition,
    });

    $(".tagsInput").tagsinput("items");

    // $('.summernote').summernote({
    //     height: 500,
    //     popover: {
    //         image: [],
    //         link: [],
    //         air: []
    //     }
    // });

    $(".editor").each(function (el) {
        var $this = $(this);
        var buttons = $this.data("buttons");
        buttons = !buttons
            ? "bold,underline,italic,hr,|,ul,ol,|,align,paragraph,|,image,table,link,undo,redo"
            : buttons;

        var editor = new Jodit(this, {
            uploader: {
                insertImageAsBase64URI: true,
            },
            toolbarAdaptive: false,
            defaultMode: "1",
            toolbarSticky: false,
            showXPathInStatusbar: false,
            buttons: buttons,
        });
    });

    $(".nav-tabs a").click(function () {
        $(this).tab("show");
    });

    slickInit();

    // color select select2
    $(".color-var-select").select2({
        templateResult: colorCodeSelect,
        templateSelection: colorCodeSelect,
        escapeMarkup: function (m) {
            return m;
        },
    });
    function colorCodeSelect(state) {
        var colorCode = $(state.element).val();
        if (!colorCode) return state.text;
        return (
            "<span class='color-preview' style='background-color:" +
            colorCode +
            ";'></span>" +
            state.text
        );
    }
});

$(window).on("load", function () {});

$(window)
    .scroll(function () {
        var scrollDistance = $(window).scrollTop();
        $(".sub-category-menu.active").each(function (i) {
            if ($(this).position().top + 120 <= scrollDistance) {
                $(".all-category-menu li.active").removeClass("active");
                $(".all-category-menu li").eq(i).addClass("active");
            }
        });

        var b = $(window).scrollTop();

        if (b > 120) {
            $(".logo-bar-area").addClass("sm-fixed-top");
        } else {
            $(".logo-bar-area").removeClass("sm-fixed-top");
        }
    })
    .scroll();

$(document).ajaxComplete(function () {
    $(".selectpicker").each(function (index, element) {
        $(".selectpicker").select2({});
    });
});
