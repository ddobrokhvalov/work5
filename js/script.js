$(document).ready(function(){
	$('.user_form').submit(function(){
		$('.user_form .required').each(function(){
			if(!$(this).val()){
				$(this).addClass('error_input');
			}else{
				$(this).removeClass('error_input');
			}
		});
		if($('.error_input').size()){
			return false;
		}
	});
});