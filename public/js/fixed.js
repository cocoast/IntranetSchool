$(document).ready(function(){
		var altura=$('.asignatura').offset().top;

		$(window).on('scroll',function(){
			if($(window).scrollTop()>altura){
				$('.asignatura').addClass('asignatura-fixed');
			}else{
				$('.asignatura').removeClass('asignatura-fixed');
			}
		});
	});