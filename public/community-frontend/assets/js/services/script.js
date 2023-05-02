// mobile menu 
$(".mobile-btn").click(function(){
    $(".service-responsive-menu").toggleClass("active");
});

// like 
$('.service-like').on('click',function(){
    $(this).toggleClass('color-change')
})

// featured service active 
$('.featured-service-active').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: false,
    // autoplaySpeed: 1000,
    arrows: true,
    dots: false,
    nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
    prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          // infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
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

//service testimoni active
$('.service-testimoni-active').slick({
  slidesToShow: 2,
  slidesToScroll: 1,
  autoplay: false,
  // autoplaySpeed: 1000,
  arrows: true,
  dots: false,
  nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
  prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
  responsive: [
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
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

//pagination active
$('.service-pagination a').on('click',function(){
  $('.service-pagination a').removeClass('active');
  $(this).addClass('active')
})

//Gallary active
$('.service-gallary-active').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  arrows: true,
  dots: false,
  nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
  prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
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

//Related service active
$('.related-service-active').slick({
  slidesToShow: 2,
  slidesToScroll: 1,
  autoplay: false,
  // autoplaySpeed: 1000,
  arrows: true,
  dots: false,
  nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
  prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
  responsive: [

    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
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


$(".play-icon").modalVideo({
  channel:'youtube',
});


// $('.').slick({
//   slidesToShow: 3,
//   slidesToScroll: 1,
//   autoplay: false,
//   // autoplaySpeed: 1000,
//   arrows: true,
//   dots: false,
//   nextArrow: "<button class='slick-prev pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
//   prevArrow: "<button class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
//   responsive: [
//     {
//       breakpoint: 1024,
//       settings: {
//         slidesToShow: 3,
//         slidesToScroll: 1,
//         infinite: true,
//         dots: false
//       }
//     },
//     {
//       breakpoint: 768,
//       settings: {
//         slidesToShow: 2,
//         slidesToScroll: 1
//       }
//     },
//     {
//       breakpoint: 576,
//       settings: {
//         slidesToShow: 1,
//         slidesToScroll: 1
//       }
//     }
//     // You can unslick at a given breakpoint now by adding:
//     // settings: "unslick"
//     // instead of a settings object
//   ]
// });
// $('.video-active').slick({
//   infinite: true,
//   slidesToShow: 3,
//   slidesToScroll: 3
// });
// for maps 

$(document).ready(function(){
  $('.video-active').slick({
    infinite: true,
    slidesToShow: 3,
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
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
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
});

$('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
  console.log('new tab')
  $('.video-active').slick('setPosition');
})
function initMap() {
  const myLatLng = { lat: 22.818650192043926, lng: 89.55351336533637 };
  const map = new google.maps.Map(document.getElementById("serviceMap"), {
    zoom: 20,
    center: myLatLng,
  });

  // new google.maps.Marker({
  //   position: myLatLng,
  //   map,
  // });

  const image = 
  "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
const beachMarker = new google.maps.Marker({
  position: myLatLng ,
  map,
  icon: image,
  title: "AppsInception",
});
}

window.initMap = initMap;