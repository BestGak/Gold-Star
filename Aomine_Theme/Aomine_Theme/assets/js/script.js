// sliders
jQuery(document).ready(function() {
    jQuery('.portfolio__gallery').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
        prevArrow: jQuery('.portfolio__left'),
        nextArrow: jQuery('.portfolio__right'),
        responsive: [
            {
              breakpoint: 1023,
              settings: "unslick"
            }
          ]
    });

    jQuery('.reviews__container').slick({
      infinite: false,
      slidesToShow: 2,
      slidesToScroll: 2,
      prevArrow: jQuery('.reviews__left'),
      nextArrow: jQuery('.reviews__right'),
      responsive: [
          {
            breakpoint: 1023,
            settings: "unslick"
          }
        ]
  });
});

// header
window.addEventListener('scroll' , () => window.pageYOffset > 100 ? document.querySelector('header').style.position = 'fixed' : document.querySelector('header').style.position = 'initial')

// header menu

const menuBtn = document.querySelector('.menu-btn');
menuBtn.addEventListener('click' , () => document.querySelector('html').classList.toggle('active'));




Fancybox.bind("[data-fancybox]", {
  // Custom options for all galleries
});

const smoothLinks = document.querySelectorAll('a[href^="#"]');
for (let smoothLink of smoothLinks) {
    smoothLink.addEventListener('click', function (e) {
        e.preventDefault();
        const id = smoothLink.getAttribute('href');

        document.querySelector(id).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
};
	
// portfolio img 
var myTags = document.querySelectorAll(".portfolio-page__tab");
var getUrl = window.location;

    [].forEach.call(document.querySelectorAll('.portfolio-page__tab'), function(t) {
      t.addEventListener('click', function() {
        //t.preventDefault();
        for (var i = 0; i < myTags.length; i++) {
            myTags[i].classList.remove("tab--active");
        }
        this.classList.add("tab--active");
        var attr = this.getAttribute("data-slug")
        var request = new XMLHttpRequest();
        var url = homepage_js.homeurl + '/wp-admin/admin-ajax.php';
        request.open('POST', url, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
        request.send('category='+attr+'&action=filter_category_portfolio');
        request.onload = function () {
            if (this.status >= 200 && this.status < 400) {
              var appended = document.querySelector('.portfolio-page__content');
              var new_content = this.response;
              appended.innerHTML = new_content;
              //console.log(new_content);
            } else {
            //console.log(this.response);
            }
        };
        request.onerror = function() {
            // Connection error
        };

      });
    });