//main header
$(".left-content-list li a").on("click", function () {
  $(".left-content-list li a").removeClass("main-menu-active");
  $(this).addClass("main-menu-active");
});

//gallery header
$(".gallery-menu-list li a").on("click", function () {
  $(".gallery-menu-list li a").removeClass("gallery-menu-active");
  $(this).addClass("gallery-menu-active");
});

// header top remove
$('.close').on('click', function () {
  $(".header-top").addClass('active');
})




// header modal list start

var paymentWay = document.getElementById('payment_way');
function showPayment() {
  paymentWay.classList.toggle("active");
}

var language = document.getElementById('languageOption');
function showLanguage() {
  language.classList.toggle('show')
}


/* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "320px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

// let language = document.getElementsByClassName('.language');
// $('.payment').on('click', function(){
//   $(this).on('click', function(){
//     $('.payment-way').removeClass('active')
//   })
//   $('.payment-way').addClass('active')
// })


// login account modal 
$('#login_account').click(function () {
  $("#myModal").attr("style", "display:block")
  $(".blank-div").toggleClass("active");
})
$('#closeBtn').click(function () {
  $("#myModal").attr("style", "display:none")
})
$('.blank-div').click(function () {
  $("#myModal").attr("style", "display:none")
  $(this).removeClass("active")
})


// hero slider section start 

$(document).ready(() => {
  $('.hero-slider__wrapper').slick({
    autoplay: false,
    autoplaySpeed: 1000,
    arrows: true,
    dots: true,
    nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
    prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",

  })
})
// hero slider section end 





// week deals active 
$(function () {
  $('.card-container-active').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: false,
    // autoplaySpeed: 1000,
    arrows: true,
    dots: false,
    nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
    prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });
})

// fresh delivery card active 

$('.delivery-card-active').slick({
  slidesToShow: 6,
  slidesToScroll: 1,
  autoplay: false,
  // autoplaySpeed: 1000,
  arrows: true,
  dots: false,
  nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
  prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});


// menu tab slider 
$('.slider-active').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  infinite: true,
  autoplay: false,
  // autoplaySpeed: 1000,
  arrows: true,
  dots: false,
  nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
  prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
$('button[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  $('.slider-active').slick('setPosition');
})
// $(document).on("#home-tab",function(){
//   console.log('hello click')
//   $('.slider-active').slick('refresh');
// });

// $(".slider-active").owlCarousel({
//   items: 4,
// });


// bestseller active

$('.bestseller-active').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  autoplay: false,
  // autoplaySpeed: 1000,
  arrows: true,
  dots: false,
  // nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
  // prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});

