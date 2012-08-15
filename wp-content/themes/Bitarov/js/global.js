$(window).load(function() {
     $('#featured').orbit({
     animation: 'horizontal-push',                  // вид анимации: fade, horizontal-slide, vertical-slide, horizontal-push
     animationSpeed: 300,                // скорость анимации в мс
     timer: false,              // показывать таймер: true или false
     advanceSpeed: 4000,          // если таймер включен, то указывается время между переходами в мс 
     pauseOnHover: false,          // пауза слайдера при наведении курсора
     startClockonmouseout: true,      // запускать часы при выводе курсора из области слайдера
     startClockonmouseoutAfter: 1,      // через какое время после вывода курсора из области слайдера таймер запустится
     directionalNav: true,          // ручная навигация
     captions: true,              // использовать заголовки?
     captionAnimation: 'slideOpen',          // анимация для заголовков: fade, slideOpen, none
     captionAnimationSpeed: 800,      // скорость анимации заголовков в мс
     bullets: true,             // true или false для активации навигации с миниатюрами
     bulletThumbs: false,         // миниатюры для "точек"
     bulletThumbLocation: '',         // путь до местонахождения миниатюр
     afterSlideChange: function(){}      // пустая функция
	});


    // hide #back-top first
	$("#back-top").hide();

	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
});