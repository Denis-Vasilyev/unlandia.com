// Empty JS for your own code to be here

$(document).ready(function(){
  $('input').iCheck({
    //checkboxClass: 'icheckbox_flat-red',
    radioClass: 'iradio_flat-red'
  });
  $('input:checkbox[name=uermUseAdditParams]').iCheck('destroy');
  $('#accept_border_values').iCheck('destroy');
});

$('.topdf-form').submit(function(){
	var form = $(this);
	$(this).find('input[type=radio]:checked').each(function(){
		var name = $(this).attr('name');
		var id = $(this).attr('id');
		var value = $('label[for="' +  id + '"]').text();
		form.append('<input type="hidden" name="' + name + '_mod" value="' + value + '">');			
	});		
	
	return true;
});
