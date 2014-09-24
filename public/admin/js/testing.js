jQuery('document').ready(function () {
 	
 	jQuery('#form1').submit(function () {
		//alert('here'); return false();
		var phn = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
		//var phn = /^(([^<>()[\]\\.,;:\s\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var email_val = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	//var website_link_val = /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
	var website_link_val = /^(www)[^ "]+$/;
	
	if(jQuery('#email').length > 0){
		if(jQuery('#email').val() != '') {
			if(!email_val.test(jQuery('#email').val())) {
				jQuery('form').prepend('<p>Please enter valid Email ID</p>');
				//alert('Please enter valid Email ID');
				return false;
			 }
		}
	}
	
    /*if(jQuery('#contact_phone').val() != '') {
	    if(!phn.test(jQuery('#contact_phone').val())) {
	     	
	    	jQuery('form').prepend('<p>Please enter valid Mobile Number</p>');
	     	//alert('Please enter valid Mobile Number');
	     	return false;
	    }
	}*/

		if(jQuery('#phone').length > 0){

			if(jQuery('#phone').val() != '') {
				if(!phn.test(jQuery('#phone').val())) {
					jQuery('form').prepend('<p>Please enter valid Phone Number</p>');
					//alert('Please enter valid Phone Number');
					return false;
				}
			}
		}

		
		if(jQuery('#mobile').length > 0){

			if(jQuery('#mobile').val() != '') {
			    if(!phn.test(jQuery('#mobile').val())) {
			     	jQuery('form').prepend('<p>Please enter valid Mobile Number</p>');
			     	//alert('Please enter valid Phone Number');
			     	return false;
			    }
			}

		}

		if(jQuery('#website_link').length > 0){

			if(jQuery('#website_link').val() != '') {
			    if(!website_link_val.test(jQuery('#website_link').val())) {
			     	
			    	jQuery('form').prepend('<p>Please enter valid Website Link</p>');
			     	//alert('Please enter valid Website Link');
			     	return false;
			    }
	   		}

		}    
	});
	
 });