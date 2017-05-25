
$(document).ready(function(){

	// bind maxlength (row) to textarea
	$('textarea').bind('keyup paste', function(){

		var $x = $(this);
		// set maxlength
		if($x.attr('rows').length > 0){
			var i = parseInt($x.attr('rows'));
		}else{
			var i = 500;
		}

		// get variables
		var t = $x.val();
    var c = t.length;

		// trim limit
    if(c > i){
     $x.val(t.substr(0, i));
    }
  });

	// hide help box until hover
	$('.fiHelp').hover(function(){
		$(this).find('div').show();
	},function(){
		$(this).find('div').hide();
	});

	// reveal hidden blocks for select boxes
	// <div class="<source name> hide" title="<source value>">
	$('.fhb select, .fhb input:checkbox').change(function(){
		var $x = $(this);
		var t = $x.attr('name');
		if($x.is(':checked') || $x.val() == $('.' + t).attr('title')){
			$('.' + t).show();
		}else{
			$('.' + t).hide();
		}
	});

	// Group CheckBox (GCB)
	$('.gcb input:checkbox').change(function(){
		var $x = $(this);
		if($x.is(':checked')){
			$x.parent().find('label').addClass('checked');
		}else{
			$x.parent().find('label').removeClass('checked');
		}
	});

	// submit form
	$('button').on('click',function(){

		var form = '#' + $(this).closest('form').attr('id');

		// reset form error messages
		$('.fInfo').css('visibility','hidden').removeClass('msg eMsg');
		$(form + ' .fiError').removeClass('fiError');

		// send
		$.ajax({
  		url: $(form).attr('action'),
  		data: $(form).serialize()+'&ajax=1',
			type: 'POST',
			timeout: 60000,
    	async: true,
			error: function(xhr,s,e){
				$('.fInfo').text('Processing Error! ' + e).addClass('eMsg').css('visibility','visible');
			},
			success: function(x){

				var r = eval(x);

				if(r[0] > 0){ // pass

					// run alternative function if set, data in r[2] (return)
					// ex. redirect to another page
					if(typeof(onSuccess) != 'undefined'){
						onSuccess(r[2]);
					}

					// add id to form if missing and form is not reset
					if(!$('#id').val() && r[0] == 1){
						$('#id').val(r[2]);
					}

					// display response
					$('.fInfo').text(r[1]).addClass('msg').css('visibility','visible');

					// reset form if trigger is set
					if(r[0] == 2){
						$(form).trigger('reset');
					}


				}else{ // fail

					$('.fInfo').text(r[1]).addClass('eMsg').css('visibility','visible');

					// run alternative function if fail, data in r[2] (return)
					if(typeof(onFail) != 'undefined'){
						onFail(r[2]);
					}else if($.isArray(r[2])){ // if array, display errors
						for(var i=0; i < r[2].length; i++) {
							// make red
    						$('#'+r[2][i][0]).parent().find('LABEL').addClass('fiError');
						}
					}
				}
			}
		});
		return false;
	}); // submit form
}); // doc ready
