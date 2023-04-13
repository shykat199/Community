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

let imgCloseBtn = document.getElementById('imgClose');

imgInp.onchange = evt => {
  const [file] = imgInp.files
  let imgCloseBtn = document.getElementById('imgClose');
  if (file) {
    imgCloseBtn.style.display = "block"
    previewImg.src = URL.createObjectURL(file)
  }
  imgCloseBtn.addEventListener("click", function() {
    if (file) {
      previewImg.src = URL.revokeObjectURL(null)
      imgCloseBtn.style.display = "none"
    }
  });
}