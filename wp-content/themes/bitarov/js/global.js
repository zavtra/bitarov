$(window).load(function() {

// Orbit Slider
     $('#featured').orbit({
     animation: 'horizontal-push',        // ��� ��������: fade, horizontal-slide, vertical-slide, horizontal-push
     animationSpeed: 300,                // �������� �������� � ��
     timer: false,              // ���������� ������: true ��� false
     advanceSpeed: 4000,          // ���� ������ �������, �� ����������� ����� ����� ���������� � �� 
     pauseOnHover: false,          // ����� �������� ��� ��������� �������
     startClockonmouseout: true,      // ��������� ���� ��� ������ ������� �� ������� ��������
     startClockonmouseoutAfter: 1,      // ����� ����� ����� ����� ������ ������� �� ������� �������� ������ ����������
     directionalNav: true,          // ������ ���������
     captions: true,              // ������������ ���������?
     captionAnimation: 'slideOpen',          // �������� ��� ����������: fade, slideOpen, none
     captionAnimationSpeed: 800,      // �������� �������� ���������� � ��
     bullets: true,             // true ��� false ��� ��������� ��������� � �����������
     bulletThumbs: false,         // ��������� ��� "�����"
     bulletThumbLocation: '',         // ���� �� ��������������� ��������
     afterSlideChange: function(){}      // ������ �������
	});
	
// Orbit Slider
     $('#fond-slider').orbit({
     animation: 'horizontal-slide',        // ��� ��������: fade, horizontal-slide, vertical-slide, horizontal-push
     animationSpeed: 300,                // �������� �������� � ��
     timer: false,              // ���������� ������: true ��� false
     advanceSpeed: 4000,          // ���� ������ �������, �� ����������� ����� ����� ���������� � �� 
     pauseOnHover: true,          // ����� �������� ��� ��������� �������
     startClockonmouseout: true,      // ��������� ���� ��� ������ ������� �� ������� ��������
     startClockonmouseoutAfter: 1,      // ����� ����� ����� ����� ������ ������� �� ������� �������� ������ ����������
     directionalNav: true,          // ������ ���������
     captions: true,              // ������������ ���������?
     captionAnimation: 'slideOpen',          // �������� ��� ����������: fade, slideOpen, none
     captionAnimationSpeed: 800,      // �������� �������� ���������� � ��
     bullets: false,             // true ��� false ��� ��������� ��������� � �����������
     bulletThumbs: false,         // ��������� ��� "�����"
     bulletThumbLocation: '',         // ���� �� ��������������� ��������
     afterSlideChange: function(){}      // ������ �������
	});

//������ �����
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

});


//Placeholder
(function(a){a.extend({placeholder:{settings:{focusClass:"placeholderFocus",activeClass:"placeholder",overrideSupport:false,preventRefreshIssues:true},debug:false,log:function(b){if(!a.placeholder.debug){return}b="[Placeholder] "+b;a.placeholder.hasFirebug?console.log(b):a.placeholder.hasConsoleLog?window.console.log(b):alert(b)},hasFirebug:"console" in window&&"firebug" in window.console,hasConsoleLog:"console" in window&&"log" in window.console}});a.support.placeholder="placeholder" in document.createElement("input");a.fn.plVal=a.fn.val;a.fn.val=function(e){a.placeholder.log("in val");if(this[0]){a.placeholder.log("have found an element");var d=a(this[0]);if(e!=undefined){a.placeholder.log("in setter");var c=d.plVal();var b=a(this).plVal(e);if(d.hasClass(a.placeholder.settings.activeClass)&&c==d.attr("placeholder")){d.removeClass(a.placeholder.settings.activeClass)}return b}if(d.hasClass(a.placeholder.settings.activeClass)&&d.plVal()==d.attr("placeholder")){a.placeholder.log("returning empty because it's a placeholder");return""}else{a.placeholder.log("returning original val");return d.plVal()}}a.placeholder.log("returning undefined");return undefined};a(window).bind("beforeunload.placeholder",function(){var b=a("input."+a.placeholder.settings.activeClass);if(b.length>0){b.val("").attr("autocomplete","off")}});a.fn.placeholder=function(b){b=a.extend({},a.placeholder.settings,b);if(!b.overrideSupport&&a.support.placeholder){return this}return this.each(function(){var c=a(this);if(!c.is("[placeholder]")){return}if(c.is(":password")){return}if(b.preventRefreshIssues){c.attr("autocomplete","off")}c.bind("focus.placeholder",function(){var d=a(this);if(this.value==d.attr("placeholder")&&d.hasClass(b.activeClass)){d.val("").removeClass(b.activeClass).addClass(b.focusClass)}});c.bind("blur.placeholder",function(){var d=a(this);d.removeClass(b.focusClass);if(this.value==""){d.val(d.attr("placeholder")).addClass(b.activeClass)}});c.triggerHandler("blur");c.parents("form").submit(function(){c.triggerHandler("focus.placeholder")})})}})(jQuery);