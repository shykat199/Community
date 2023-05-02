// side nav start 
$(".sidenav_bar").click(function(){
  $(".community-sidenav").toggleClass("main");
  $(this).toggleClass('active')
  if($(this).hasClass('active')){
    $(this).find('i').addClass("fa-times").removeClass("fa-bars");    
  }else{
    $(this).find('i').addClass("fa-bars").removeClass("fa-times");
  }
});


// mobile menu 
$(".menu-show").click(function(){
  $(".menu_list").toggleClass("main");
});

// sidebar active 
document.querySelectorAll(".sidebar-list li a").forEach((link) => {
    if (link.href === window.location.href) {
        link.classList.add("side-active");
        link.setAttribute("aria-current", "page");
    }
});

// prevew media

// let imgCloseBtn = document.getElementsByClassName('imgClose');
// const imgInp = document.getElementsByClassName('imgInp')
// imgInp.onchange = evt => {
//   const [file] = imgInp.files
//   let imgCloseBtn = document.getElementsByClassName('imgClose');
//   if (file) {
//     imgCloseBtn.style.display = "block"
//     previewImg.src = URL.createObjectURL(file)
//   }
//   imgCloseBtn.addEventListener("click", function() {
//     if (file) {
//       previewImg.src = URL.revokeObjectURL(null)
//       imgCloseBtn.style.display = "none"
//     }
//   });
// }
let files
$(document).on('change','.imgInp',function(e){
 files = this.files
  let previewImg =  $(this).parents('.upload-media').find('.previewImg')
  if(files[0]){
    previewImg.attr('src', URL.createObjectURL(files[0]))
    $('.imgClose').css("display", "block")
  }
})
$(document).on('click','.imgClose',function(){
  let previewImg =  $(this).parents('.upload-media').find('.previewImg')
  previewImg.attr('src','')
  $(this).css("display", "none")
})


// online person active 
$('.chat-online').slick({
  infinite: true,
  loop: true,
  variableWidth: false,
  slidesToShow: 9,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  draggable: true,
  arrows: false,
  dots: false,
  responsive: [
    {
      breakpoint: 1500,
      settings: {
        slidesToShow: 8,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 4,
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

// video like 
$('.video-react-icon i').click(function(){
  $(this).toggleClass('active')
  if ($(this).hasClass('active')) {
    $(this).addClass('fa-heart').removeClass('fa-heart-o')
  } else {
    $(this).removeClass('fa-heart').addClass('fa-heart-o')    
  }
})
