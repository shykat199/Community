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


document.querySelectorAll(".sidebar-list li a").forEach((link) => {
    if (link.href === window.location.href) {
        link.classList.add("side-active");
        link.setAttribute("aria-current", "page");
    }
});