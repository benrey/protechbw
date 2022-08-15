// You can also use <link> for styles
window.addEventListener('load', AOS.refresh);
AOS.init();
AOS.refresh();

$(window).scroll(function () {
  AOS.init();
  AOS.refresh();
  if ($(document).scrollTop() > 20) {
    $('header').addClass('visiblebg');
    $('con').addClass('visiblebg')
  } else {
    $('header').removeClass('visiblebg');
    $('con').removeClass('visiblebg');
    $('con').css('fade-up');
  }
});

$('.navbar-collapse').on('show.bs.collapse', function (e) {
  $('con').addClass('height');
})
$('.navbar-collapse').on('hide.bs.collapse', function (e) {
  $('con').removeClass('height');
})

$(document).ready(function () {
  // run test on initial page load
  $('.container-fluid h1').delay(1000).fadeTo(1000, 1);
  $('.container-fluid h2').delay(1200).fadeTo(1000, 1);
  $('.container-fluid p').delay(1500).fadeTo(1000, 1);
  $('.box').delay(1600).fadeTo(1000, 1);
  $('.block-capabilities h3').delay(1800).fadeTo(1000, 1);
  $('.hidden').hide();
  $('.bullets li').hover(function () {
    $(this).find('.show').stop(true, true).hide();
    $(this).find('.hidden').fadeIn(700);
  }, function () {
    $(this).find('.show').fadeIn(700);
    $(this).find('.hidden').stop(true, true).hide();
  })
  // label
  $('#section2 .label a').hover(
    function() {
        $(this).closest('.project-thumb').find('.img').toggleClass('hover');
    }, function() {
        $(this).closest('.project-thumb').find('.img').toggleClass('hover');
    });

    // image
    $('#section2 .img').hover(
        function() {
            $(this).closest('.project-thumb').find('.label a').toggleClass('hover');
        }, function() {
            $(this).closest('.project-thumb').find('.label a').toggleClass('hover');
    });
;
  
  
  /*$('ul li').hover(function () {
    var data_num = $(this).data('num');
    $('.hidden').each(function () {
      var iam = $(this);
      if (iam.attr('id') == data_num) {
        $('span.number').addClass('hidden');
      } else {
          $('span').removeClass('hidden');
      }
    });
  });*/





/*  $('.bullets li').hover(
    function () {
      var number = $('a href').id(this);
      alert(number);
    },
    function() {
        var $this = ('span').$(this); // caching $(this)
        $('span').text($this.data('defaultText'));
    }
);*/
  $('#features').delay(1600).fadeTo(2000, 1);
  $(icon[0]).click(function(){
    if($(pushDown).hasClass("push")){
      pushDown.className = "pushUp";
    }
    else{
      pushDown.className = "push";
    }
  })
  
 //capabilities jquery script start

  var slider = $('.slideshow');
  slider.slick({
      infinite: true,
      slidesToShow: 1,
      autoplay: false,
      autoplaySpeed: 5000,
      speed: 300,
      fade: true,
      adaptiveHeight: true,
      dots: false,
      arrows: false,
      pauseOnHover: true,
      pauseOnFocus: true   
  }).slick("slickPause");
  
  setTimeout(function() {
      slider.slick("slickPlay");
  }, 3000);

  // pause slideshow on hover
  $('.bullets').hover(
      function() {
          slider.slick("slickPause");
      },
      function() {
          slider.slick("slickPlay");
      }
  );
  
  // change slide on nav hover
  $('.bullets li').hoverIntent(function(e) {
      e.preventDefault();
      var num = $(this).data('num');
      slider.slick('slickGoTo', parseInt(num));
      $('.bullets li.active').removeClass('active');
      $(this).addClass('active',false);

   });

  // change nav on slide change
  $('.slideshow').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
      $('.bullets li.active').removeClass('active');
      $('.bullets li[data-num=' + nextSlide + ']').addClass('active');
      $('.bullets span.active').removeClass('.show').stop(true, true).hide();
      $('.bullets span.active').addClass('.hidden');
    
  });
  $('.box li').hoverIntent(function(e) {
    e.preventDefault();
    var num = $(this).data('num');
    
    slider.slick('slickGoTo', parseInt(num));

    $('.box li.active').removeClass('active');
    $(this).addClass('active');
});

//capabilities jquery script end

checkSize();

  // run test on resize of the window
  $(window).resize(checkSize);
});

//Function to the css rule
function checkSize(){
  if ($(".navbar-nav").css("flex-direction") == "row" ) {
    $('con').removeClass('height');
    $('.navbar-collapse').removeClass('show');
    $('.navbar-toggler').addClass('collapsed');
  }
}

var icon = document.getElementsByClassName("icon-bars");
var pushDown = document.getElementById("push");

