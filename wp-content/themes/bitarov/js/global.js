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

    //Scrolling-parallax

    $(window).scroll(function() {
        if (!fixed_div) return;
        var top = $(window).scrollTop();
        if (top>fixed_top)
         {
         if (fixed_fix) return;
         fixed_fix = true;
         fixed_div.style.position = 'fixed';
         $('#wrap-fixed').css('top', '-'+fixed_top+'px');
         }
        else
         {
         if (!fixed_fix) return;
         fixed_fix = false;
         fixed_div.style.position = 'absolute';
         $('#wrap-fixed').css('top', '0');
         }
    });

});

fixed_div = null;
fixed_top = 0;
fixed_fix = false;
$(window).ready(function() {
  var div;
  if (div=elem('paginator-fixed')) fixed_top = $(div).position().top;
  else if (div=elem('rubrikator-fixed')) fixed_top = $(div).position().top;
  else if (div=elem('years-fixed')) fixed_top = $(div).position().top;
  fixed_top -= 20;
  fixed_div = elem('wrap-fixed');

  if (location.hash=='#comments') $('.wrp-artic-comment').css('display', 'block');

});

function newcomment()
 {
 var display = $('.wrp-artic-comment').css('display');
 if (display=='none') $('.wrp-artic-comment').fadeIn();
 else $('.wrp-artic-comment').fadeOut();
 return false;
 }

function actFrameNavigate(link)
 {
 // var top = $('.wrp-activity').position().top; // неправильно считается
 $('body,html').animate({scrollTop:420}, 800);
 $('.list_news .news').removeClass('current');
 $(link.parentNode).addClass('current');
 var frame = elem('actionsFrame');
 var url = link.href.replace(/\/$/, '') + '/framed/';
 frame.src = url;
 return false;
 }

function messageFundClose()
 {
 $('#messageFundShadow').fadeOut(400);
 $('#messageFundBox').fadeOut(400);
 return false;
 }

function messageFundOpen()
 {
 $('#messageFundShadow').fadeIn(600);
 $('#messageFundBox').fadeIn(400);
 return false;
 }

// -------------------------------------------------- Показать предыдущие записи

function elem(id) {return document.getElementById(id)}

function httpget(url)
 {
 var xhr, result;
 if (window.XMLHttpRequest) xhr = new XMLHttpRequest();
 else xhr = new ActiveXObject("Microsoft.XMLHTTP");
 xhr.open('GET', url, false);
 xhr.send('');
 if ((xhr.status<200) || (xhr.status>299)) result = false;
 else result = xhr.responseText;
 delete xhr;
 return result;
 }

function showmore()
 {
 if (more_loading) return;
 more_loading = true;
 $('#old-loader').css('display', 'inline');
 current_page_number_more++;
 var url = '/index.php?bt_json=get_posts';
 url += '&category_id=' + current_category_id;
 url += '&pg=' + current_page_number_more;
 try {var response = eval('('+httpget(url)+')');}
 catch (error) {$('.button-show-old').css('display', 'none'); return;}
 var top = $('.button-show-old').position().top;
 if (typeof(response.info.next_page)!='number') $('.button-show-old').css('display', 'none');
 var posts_list = elem('posts_list');
 var div, snipet;
 div = document.createElement('div');
 div.style.margin = '10px 0';
 div.style.borderTop = '1px dashed #CCC';
 posts_list.appendChild(div);
 for (num in response.items)
  {
  div = document.createElement('div');
  snipet = post_template.replace(/__POST_LINK__/, response.items[num].post_link);
  snipet = snipet.replace(/__POST_LINK__/, response.items[num].post_link);
  snipet = snipet.replace(/__POST_TITLE__/, response.items[num].post_title);
  snipet = snipet.replace(/__CATEGORY_NAME__/, response.items[num].category_name);
  snipet = snipet.replace(/__CATEGORY_LINK__/, response.items[num].category_link);
  snipet = snipet.replace(/__POST_EXCERPT__/, response.items[num].post_excerpt);
  snipet = snipet.replace(/__OPINION__/, response.items[num].opinion);
  snipet = snipet.replace(/__POST_DATE__/, response.items[num].post_date_dm + ' ' + response.items[num].post_date_y);
  snipet = snipet.replace(/__POST_DATE_DM__/, response.items[num].post_date_dm);
  snipet = snipet.replace(/__POST_DATE_Y__/, response.items[num].post_date_y);
  snipet = snipet.replace(/__TAGS__/, response.items[num].tags);
  snipet = snipet.replace(/__COMMENTS_COUNT__/, response.items[num].comments_count);
  div.innerHTML = snipet;
  posts_list.appendChild(div);
  }
 $('body,html').animate({scrollTop:top}, 800);
 }

//Placeholder
(function(a){a.extend({placeholder:{settings:{focusClass:"placeholderFocus",activeClass:"placeholder",overrideSupport:false,preventRefreshIssues:true},debug:false,log:function(b){if(!a.placeholder.debug){return}b="[Placeholder] "+b;a.placeholder.hasFirebug?console.log(b):a.placeholder.hasConsoleLog?window.console.log(b):alert(b)},hasFirebug:"console" in window&&"firebug" in window.console,hasConsoleLog:"console" in window&&"log" in window.console}});a.support.placeholder="placeholder" in document.createElement("input");a.fn.plVal=a.fn.val;a.fn.val=function(e){a.placeholder.log("in val");if(this[0]){a.placeholder.log("have found an element");var d=a(this[0]);if(e!=undefined){a.placeholder.log("in setter");var c=d.plVal();var b=a(this).plVal(e);if(d.hasClass(a.placeholder.settings.activeClass)&&c==d.attr("placeholder")){d.removeClass(a.placeholder.settings.activeClass)}return b}if(d.hasClass(a.placeholder.settings.activeClass)&&d.plVal()==d.attr("placeholder")){a.placeholder.log("returning empty because it's a placeholder");return""}else{a.placeholder.log("returning original val");return d.plVal()}}a.placeholder.log("returning undefined");return undefined};a(window).bind("beforeunload.placeholder",function(){var b=a("input."+a.placeholder.settings.activeClass);if(b.length>0){b.val("").attr("autocomplete","off")}});a.fn.placeholder=function(b){b=a.extend({},a.placeholder.settings,b);if(!b.overrideSupport&&a.support.placeholder){return this}return this.each(function(){var c=a(this);if(!c.is("[placeholder]")){return}if(c.is(":password")){return}if(b.preventRefreshIssues){c.attr("autocomplete","off")}c.bind("focus.placeholder",function(){var d=a(this);if(this.value==d.attr("placeholder")&&d.hasClass(b.activeClass)){d.val("").removeClass(b.activeClass).addClass(b.focusClass)}});c.bind("blur.placeholder",function(){var d=a(this);d.removeClass(b.focusClass);if(this.value==""){d.val(d.attr("placeholder")).addClass(b.activeClass)}});c.triggerHandler("blur");c.parents("form").submit(function(){c.triggerHandler("focus.placeholder")})})}})(jQuery);