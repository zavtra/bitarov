// ---------------------------------------------------- Начало загрузки страницы

$(window).load(function() {

  // Слайдер на главной
  $('#featured').orbit({
    animation: 'horizontal-slide',        // вид анимации: fade, horizontal-slide, vertical-slide, horizontal-push
    animationSpeed: 400,                // скорость анимации в мс
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

  // Слайдер благодарностей
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
  $("#back-top").hide();
  $(function() {
    $(window).scroll(function () {
      if ($(this).scrollTop()>100) $('#back-top').fadeIn();
      else $('#back-top').fadeOut();
    });
    $('#back-top a').click(function () {
      $('body,html').animate({scrollTop:0}, 800);
      return false;
    });
  });

  $('.scroll-pane').jScrollPane();
  $(window).scroll(windowScrolled);
  $(window).resize(windowResized);
});

// ---------------------------------------------------------- Страница загружена

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

  // Для страницы с формой обратной связи
  if ($('#feedbackShadow').size()>0)
   {
   window.shadowTop = getTop(elem('feedbackShadow'));
   window.footerHeight = $('.footer').height();
   window.footerElem = $('.footer')[0];
   $(window).resize(shadowResize);
   }

  // Для страницы просмотра медиа
  $('#smi-parts-top a').click(changeMediaCategory);

  $('#paginator-events').jScrollPane();
});

// --------------------------------------------------------- При скроллинге окна

function windowScrolled()
 {
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
}

// ------------------------------------------------- При изменении размеров окна
function windowResized()
 {
 mediaWindowSetSize(); // Если открыто окно просмотра СМИ
 }

// ----------------------------------------------------------------- Комментарии

function commentsOpened()
 {
 var api = $('.scroll-pane').data('jsp');
 if (api) {api.reinitialise(); api.scrollToBottom();}
 else docScroll(getTop(elem('comments')));
 }
function commentsClosed()
 {
 var api = $('.scroll-pane').data('jsp');
 if (api) api.reinitialise();
 }
function newcomment()
 {
 var display = $('.wrp-artic-comment').css('display');
 if (display=='none') $('.wrp-artic-comment').fadeIn('fast', commentsOpened);
 else $('.wrp-artic-comment').fadeOut('fast', commentsClosed);
 return false;
 }

// ------------------ Подгрузить новую страницу во фрейм на странице мероприятий

function actFrameNavigate(link)
 {
 // var top = $('.wrp-activity').position().top; // неправильно считается
 docScroll(420);
 $('.list_news .news').removeClass('current');
 $(link.parentNode).addClass('current');
 var frame = elem('actionsFrame');
 var url = link.href.replace(/\/$/, '') + '/framed/';
 frame.src = url;
 return false;
 }

// -------------------------------------------------------- Форма обратной связи

function showGood()
 {
 $('#feedbackmsg').css('display', 'block');
 $('#feedbackmsg').css('top', '-60px');
 $('#feedbackmsg').animate({top:'+=30'});
 $('#feedbacklink').animate({top:'+=40'});
 $('#send_ok').fadeIn('fast');
 setTimeout(showMsglink, 6000);
 setTimeout(function(){$('#send_ok').fadeOut('slow');}, 6000);
 return false;
 }

function showMsglink()
 {
 $('#feedbackmsg').animate({top:'+=40'});
 $('#feedbacklink').css({top:'-30px'});
 $('#feedbacklink').animate({top:'+=30'});
 return false;
 }

function feedbackClose()
 {
 $('#feedbackShadow').fadeOut(200);
 $('#feedbackBox').slideUp(200);
 return false;
 }

function shadowResize()
 {
 var new_height = getTop(footerElem) - shadowTop + footerHeight + 50;
 $('#feedbackShadow').height(new_height);
 }

function feedbackLock(lock)
 {
 document.feedbackform.message.disabled = lock;
 document.feedbackform._name.disabled = lock;
 document.feedbackform.email.disabled = lock;
 document.feedbackform.phone.disabled = lock;
 document.feedbackform.sendbtn.disabled = lock;
 }

function feedbackOpen()
 {
 elem('feedback-errmsg').style.display = 'none';
 elem('feedback-errors').style.display = 'none';
 document.feedbackform.message.value = '';
 document.feedbackform._name.value = '';
 document.feedbackform.email.value = '';
 document.feedbackform.phone.value = '';
 feedbackLock(false);
 shadowResize();
 $('#feedbackShadow').css('display', 'block');
 $('#feedbackBox').slideDown(200);
 return false;
 }

function feedbackError(err)
 {
 var errors = new Array;
 if (err && err.err && typeof(err.err)=='object')
   {for (num in err.err) if (typeof(err.err[num])=='string') errors[errors.length] = err.err[num];}
 else if (typeof(err)=='string') errors[0] = err;
 if (errors.length<1) elem('feedback-errmsg').innerHTML = 'Произошла непредвиденная ошибка. Постараемся исправить её в ближайшее время.';
 else if (errors.length==1) elem('feedback-errmsg').innerHTML = '<strong>Ошибка:</strong> ' + errors[0];
 else
  {
  elem('feedback-errmsg').innerHTML = '<strong>Обнаружены ошибки:</strong>';
  var msg = '';
  for (num in errors) msg += "<li>" + errors[num] + "</li>";
  elem('feedback-errors').innerHTML = msg;
  $('#feedback-errors').slideDown('fast');
  }
 $('#feedback-errmsg').slideDown('fast');
 return false;
 }

function feedbackSend()
 {
 $('#feedback-errmsg').slideUp('fast');
 $('#feedback-errors').slideUp('fast');

 var postdata = {
   form: document.feedbackform.form.value,
   message: document.feedbackform.message.value,
   name: document.feedbackform._name.value,
   email: document.feedbackform.email.value,
   phone: document.feedbackform.phone.value
 }
 elem('msg-loader').style.display = 'block';
 feedbackLock(true);
 httppost('/index.php?bt_json=feedback', postdata, function(response) {
   elem('msg-loader').style.display = 'none';
   feedbackLock(false);
   try {var response = eval('('+response+')');}
   catch (error) {feedbackError(); return false;}
   if (!response || !response.ok) return feedbackError(response);
   showGood();
   feedbackClose();
 });

 return false;
 }

// ------------------------------------------------------------------------- СМИ

function changeMediaCategory()
 {
 $('#smi-parts-top li').removeClass('current-menu-item');
 $(this.parentNode).addClass('current-menu-item');
 $('#posts_list').html('');
 $('#paginator').html('');
 $('#blocks_list').html('');
 $('#media-loader').css('display', 'inline');
 var url = this.href + '/?xhr';
 httpget(url, function(new_content) {
   $('#media-loader').css('display', 'none');
   new_content = json_parse(new_content);
   if (!new_content) return false;
   $('#breadcrumbs').html(new_content.breadcrumbs);
   $('#posts_list').html(new_content.posts_list);
   $('#paginator').html(new_content.paginator);
   $('#blocks_list').html(new_content.blocks_list);
 });
 return false;
 }

current_media_id = 0;
function mediaWindowOpen(id_post)
 {
 current_media_id = id_post;
 elem('media-'+id_post).style.display = 'block';
 $('#breadcrumb-x a').attr('href', $('#post-link-'+id_post).attr('href'));
 $('#breadcrumb-x a').html($('#post-title-'+id_post).html());
 $('#breadcrumb-x').css('display', 'inline');
 mediaWindowSetSize();
 return false;
 }

function mediaWindowClose()
 {
 $('#media-'+current_media_id).fadeOut('fast');
 $('#breadcrumb-x').css('display', 'none');
 current_media_id = 0;
 return false;
 }

function mediaWindowSetSize()
 {
 if (current_media_id<1) return;
 var new_height = getTop($('.footer')[0]) - getTop(elem('media-'+current_media_id)) - 51;
 $('#media-'+current_media_id).height(new_height);
 $('.text-right_b').height(new_height-10);
 $('.video-window .text').height(new_height-10);
 $('.scroll-pane').jScrollPane();
 }

// -------------------------------------------------- Показать предыдущие записи

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
 var top = getTop(elem('button-show-old'));
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
 docScroll(top);
 }

// ----------------------------------------------------- Другие полезные функции

function elem(id) {return document.getElementById(id)}

function docScroll(top)
 {
 $('body,html').animate({scrollTop:top}, 800);
 }

function getTop(elem)
 {
 var result = 0;
 while (elem)
  {
  result += parseInt(elem.offsetTop);
  elem = elem.offsetParent;
  }
 return result;
 }

function json_parse(json)
 {
 try {json=eval('('+json+')')}
 catch (error) {return null}
 return json;
 }

function httpget(url, callback)
 {
 var xhr, result;
 if (window.XMLHttpRequest) xhr = new XMLHttpRequest();
 else xhr = new ActiveXObject("Microsoft.XMLHTTP");
 if (callback)
  {
  xhr.cbfunc = callback;
  xhr.onreadystatechange = function () {if (this.readyState==4 && typeof(this.cbfunc)=='function') this.cbfunc(this.responseText, this)};
  xhr.open('GET', url, true);
  xhr.send(null);
  return true;
  }
 xhr.open('GET', url, false);
 xhr.send(null);
 if ((xhr.status<200) || (xhr.status>299)) result = false;
 else result = xhr.responseText;
 delete xhr;
 return result;
 }

function httppost(url, params, callback)
 {
 var postdata, param, xhr, result;
 postdata = '';
 if (params && typeof(params)=='object') for (param in params) postdata += encodeURIComponent(param) + '=' + encodeURIComponent(params[param]) + '&';
 if (window.XMLHttpRequest) xhr = new XMLHttpRequest();
 else xhr = new ActiveXObject("Microsoft.XMLHTTP");
 if (callback)
  {
  xhr.cbfunc = callback;
  xhr.onreadystatechange = function () {if (this.readyState==4 && typeof(this.cbfunc)=='function') this.cbfunc(this.responseText, this)};
  xhr.open('POST', url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(postdata);
  return true;
  }
 xhr.open('POST', url, false);
 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
 xhr.send(postdata);
 if ((xhr.status<200) || (xhr.status>299)) result = false;
 else result = xhr.responseText;
 delete xhr;
 return result;
 }

function scanObject(obj)
 {
 var result = '';
 for (prop in obj) result += prop + ': ' + typeof(obj[prop]) + "\n";
 return result;
 }

// -------------------------------------------------------------- Какая-то хрень
(function(a){a.extend({placeholder:{settings:{focusClass:"placeholderFocus",activeClass:"placeholder",overrideSupport:false,preventRefreshIssues:true},debug:false,log:function(b){if(!a.placeholder.debug){return}b="[Placeholder] "+b;a.placeholder.hasFirebug?console.log(b):a.placeholder.hasConsoleLog?window.console.log(b):alert(b)},hasFirebug:"console" in window&&"firebug" in window.console,hasConsoleLog:"console" in window&&"log" in window.console}});a.support.placeholder="placeholder" in document.createElement("input");a.fn.plVal=a.fn.val;a.fn.val=function(e){a.placeholder.log("in val");if(this[0]){a.placeholder.log("have found an element");var d=a(this[0]);if(e!=undefined){a.placeholder.log("in setter");var c=d.plVal();var b=a(this).plVal(e);if(d.hasClass(a.placeholder.settings.activeClass)&&c==d.attr("placeholder")){d.removeClass(a.placeholder.settings.activeClass)}return b}if(d.hasClass(a.placeholder.settings.activeClass)&&d.plVal()==d.attr("placeholder")){a.placeholder.log("returning empty because it's a placeholder");return""}else{a.placeholder.log("returning original val");return d.plVal()}}a.placeholder.log("returning undefined");return undefined};a(window).bind("beforeunload.placeholder",function(){var b=a("input."+a.placeholder.settings.activeClass);if(b.length>0){b.val("").attr("autocomplete","off")}});a.fn.placeholder=function(b){b=a.extend({},a.placeholder.settings,b);if(!b.overrideSupport&&a.support.placeholder){return this}return this.each(function(){var c=a(this);if(!c.is("[placeholder]")){return}if(c.is(":password")){return}if(b.preventRefreshIssues){c.attr("autocomplete","off")}c.bind("focus.placeholder",function(){var d=a(this);if(this.value==d.attr("placeholder")&&d.hasClass(b.activeClass)){d.val("").removeClass(b.activeClass).addClass(b.focusClass)}});c.bind("blur.placeholder",function(){var d=a(this);d.removeClass(b.focusClass);if(this.value==""){d.val(d.attr("placeholder")).addClass(b.activeClass)}});c.triggerHandler("blur");c.parents("form").submit(function(){c.triggerHandler("focus.placeholder")})})}})(jQuery);