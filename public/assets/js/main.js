
(function($) {

	skel.breakpoints({
		wide: '(max-width: 1680px)',
		normal: '(max-width: 1280px)',
		narrow: '(max-width: 980px)',
		narrower: '(max-width: 840px)',
		mobile: '(max-width: 736px)',
		small: '(max-width: 530px)'
	});

	$(document).ready(function(){
		$(window).on('beforeunload', function() {
		    $(window).scrollTop(0);
		});
	});

	$(function() {

		// Disable animations/transitions until the page has loaded.
			$('body').addClass('is-loading');

			skel.on("load", function() {
				$('body').removeClass('is-loading');
				
			});

		// CSS polyfills (IE<9).
			if (skel.vars.IEVersion < 9)
				$(':last-child').addClass('last-child');

		// Fix: Placeholder polyfill.
			$('form').placeholder();

	});

	$('nav#nav .with-dropdown > a').click(function(e){
		e.preventDefault();

		if(!$(this).hasClass('active')){
			$('nav#nav .with-dropdown a').removeClass('active');
			$('.dropdown').removeClass('show');
		}
		$(this).toggleClass('active');
		$(this).parent().find('.dropdown').toggleClass('show');

		$('nav#nav .with-dropdown > a').each(function(){
			if($(this).hasClass('active')){
				$('body').append('<div class="dropdown-overlay"></div>');
				$('header#header nav').append('<div class="dropdown-overlay"></div>');
			}
		});
		
	});

	$(document).on('click','.dropdown-overlay, #user-wrap',function(){
		$('nav#nav .with-dropdown a').removeClass('active');
		$('.dropdown').removeClass('show');
		$('.dropdown-overlay').remove();
	});

	$('#sub-nav .with-dropdown > a, #sub-nav-mobile .with-dropdown > a').click(function(e){
		e.preventDefault();
		$(this).parent().find('.dropdown').slideToggle(200);
	});

	$('#nav-button').click(function(e){
		e.preventDefault();
		$('nav#sub-nav').slideToggle(200);
	});

	$(window).resize(function(){
		skel.on("-small", function(){
			$('nav#sub-nav').attr('style', '');
		});
	});

	//---------Form Submit
	$('form').submit(function(){
		$(this).find('button,input[type=submit]').html('<i class="fa fa-spin fa-refresh"></i>');
		$(this).find('button,input[type=submit]').prop('disabled', true);
	});

	//---------FLASH
	if($('.flash-wrap').length){
		var n = $('.flash-wrap .flash').length * 300;
		$('.flash-wrap .flash').each(function(i){
			setTimeout(function(){
				$('.flash-wrap .flash').eq(i).addClass('show');
				if(!$('.flash-wrap .flash').eq(i).hasClass('flash-important')){
					setTimeout(function(){
						$('.flash-wrap .flash').eq(i).removeClass('show');
					},5000);
				}
			},300 * (i+1));
		});

		setTimeout(function(){
			$('.flash-wrap .flash').each(function(i){
				if(!$('.flash-wrap .flash').eq(i).hasClass('flash-important')){
					$('.flash-wrap .flash').eq(i).remove();
				}
			});
		},(n*2)+5000);

		$('.flash-wrap .flash .close').click(function(){
			var elem = $(this).parent();
			elem.removeClass('show');

			setTimeout(function(){
				elem.remove();
			},500);
		});
	}

		// Firefox bug fix
	$( '.inputfile' )
		.on( 'focus', function(){ $(this).addClass( 'has-focus' ); })
		.on( 'blur', function(){ $(this).removeClass( 'has-focus' ); });

	// LOADER
	function getRandomInt(min, max) {
	    return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	var min = 0, max = 5;
	var loaded = false;

	function load(){
		if(!loaded){
			if(min < 80){
				var randInt = getRandomInt(min, max);
				var duration = getRandomInt(200,1500);
				$('#loader-filler').css({'width':''+300*(randInt/100)+'px'});
				min = min + 10; max = max + 10;
				setTimeout(load, duration);
			}
			else if (min < 95){
				var randInt = getRandomInt(min, max);
				var duration = getRandomInt(2000,4000);
				$('#loader-filler').css({'width':''+300*(randInt/100)+'px'});
				min = min + 5; max = max + 5;
				setTimeout(load, duration);
			}
		}
	}

	load();

	skel.on("load", function() {
		loaded = true;
		$('#loader-filler').css({'width':'300px'});
		setTimeout(function(){
			$('#loader').fadeOut('500');
		},500);
	});

})(jQuery);