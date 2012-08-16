$(window).load(function() {

// Orbit Slider
     $('#featured').orbit({
     animation: 'horizontal-push',        // вид анимации: fade, horizontal-slide, vertical-slide, horizontal-push
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
	
// Orbit Slider
     $('#fond-slider').orbit({
     animation: 'horizontal-slide',        // вид анимации: fade, horizontal-slide, vertical-slide, horizontal-push
     animationSpeed: 300,                // скорость анимации в мс
     timer: false,              // показывать таймер: true или false
     advanceSpeed: 4000,          // если таймер включен, то указывается время между переходами в мс 
     pauseOnHover: true,          // пауза слайдера при наведении курсора
     startClockonmouseout: true,      // запускать часы при выводе курсора из области слайдера
     startClockonmouseoutAfter: 1,      // через какое время после вывода курсора из области слайдера таймер запустится
     directionalNav: true,          // ручная навигация
     captions: true,              // использовать заголовки?
     captionAnimation: 'slideOpen',          // анимация для заголовков: fade, slideOpen, none
     captionAnimationSpeed: 800,      // скорость анимации заголовков в мс
     bullets: false,             // true или false для активации навигации с миниатюрами
     bulletThumbs: false,         // миниатюры для "точек"
     bulletThumbLocation: '',         // путь до местонахождения миниатюр
     afterSlideChange: function(){}      // пустая функция
	});

//Кнопка вверх
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
	
//jScrollPane v2
	jQuery('.scroll-pane').jScrollPane();
});

//Placeholder
(function(a){a.extend({placeholder:{settings:{focusClass:"placeholderFocus",activeClass:"placeholder",overrideSupport:false,preventRefreshIssues:true},debug:false,log:function(b){if(!a.placeholder.debug){return}b="[Placeholder] "+b;a.placeholder.hasFirebug?console.log(b):a.placeholder.hasConsoleLog?window.console.log(b):alert(b)},hasFirebug:"console" in window&&"firebug" in window.console,hasConsoleLog:"console" in window&&"log" in window.console}});a.support.placeholder="placeholder" in document.createElement("input");a.fn.plVal=a.fn.val;a.fn.val=function(e){a.placeholder.log("in val");if(this[0]){a.placeholder.log("have found an element");var d=a(this[0]);if(e!=undefined){a.placeholder.log("in setter");var c=d.plVal();var b=a(this).plVal(e);if(d.hasClass(a.placeholder.settings.activeClass)&&c==d.attr("placeholder")){d.removeClass(a.placeholder.settings.activeClass)}return b}if(d.hasClass(a.placeholder.settings.activeClass)&&d.plVal()==d.attr("placeholder")){a.placeholder.log("returning empty because it's a placeholder");return""}else{a.placeholder.log("returning original val");return d.plVal()}}a.placeholder.log("returning undefined");return undefined};a(window).bind("beforeunload.placeholder",function(){var b=a("input."+a.placeholder.settings.activeClass);if(b.length>0){b.val("").attr("autocomplete","off")}});a.fn.placeholder=function(b){b=a.extend({},a.placeholder.settings,b);if(!b.overrideSupport&&a.support.placeholder){return this}return this.each(function(){var c=a(this);if(!c.is("[placeholder]")){return}if(c.is(":password")){return}if(b.preventRefreshIssues){c.attr("autocomplete","off")}c.bind("focus.placeholder",function(){var d=a(this);if(this.value==d.attr("placeholder")&&d.hasClass(b.activeClass)){d.val("").removeClass(b.activeClass).addClass(b.focusClass)}});c.bind("blur.placeholder",function(){var d=a(this);d.removeClass(b.focusClass);if(this.value==""){d.val(d.attr("placeholder")).addClass(b.activeClass)}});c.triggerHandler("blur");c.parents("form").submit(function(){c.triggerHandler("focus.placeholder")})})}})(jQuery);