$(window).load(function() {
     $('#featured').orbit({
     animation: 'horizontal-push',                  // ��� ��������: fade, horizontal-slide, vertical-slide, horizontal-push
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