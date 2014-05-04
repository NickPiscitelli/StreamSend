$(function(){
	// remove errors on blur
	$('.pageForm :input').on('blur',function(){
		var $input = $(this);
		switch ($input.attr('type')){
			case 'email':
				var valid = validateEmail($input.val());
				$input[(valid ? "remove" : "add") + "Class"]('error')
				$input.next('.errorMessage')[valid ? 'hide' : 'show']();
				break;
			default:
				var val = $input.val();
				$input[(val ? "remove" : "add") + "Class"]('error')
				$input.next('.errorMessage')[val ? 'hide' : 'show']();
				break;
		}
	});
	// validate on submission
	$('.pageForm form').on('submit',function(e){
		var $form = $(this);
		// check fields validate (exlcuding submit)
		$form.find('input:not([type=submit])').blur();
		var bad_field = $form.find('input.error');
		if (bad_field.length){
			// show error and fail submission. focus first bad field.
			bad_field.first().focus();
			return false;
		}
	});
});

function validateEmail(email) { 
    return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}