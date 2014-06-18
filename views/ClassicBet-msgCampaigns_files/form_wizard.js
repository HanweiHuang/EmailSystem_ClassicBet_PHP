/*
 * form_wizard.js
 *
 * Demo JavaScript used on Form Wizard-page.
 */

"use strict";

$(document).ready(function(){

	//===== Form Wizard =====//

	// Config
	var form    = $('#form_item');
	var wizard  = $('#form_wizard');
	var error   = $('.alert-danger', form);
	var success = $('.alert-success', form);

	form.validate({
		doNotHideMessage: true, // To display error/ success message on tab-switch
		focusInvalid: false, // Do not focus the last invalid input
		invalidHandler: function (event, validator) {
			// Display error message on form submit

			success.hide();
			error.show();
		},
		submitHandler: function (form) {
			success.show();
			error.hide();
			
			console.log ('submit1');

			// Maybe you want to add some Ajax here to submit your form
			// Otherwise just call form.submit() or remove this submitHandler to submit the form without ajax
			
			var allInputs = $( ":input" );
			
		}
	});

	// Functions
	var displayConfirm = function() {
		$('#tab4 .form-control-static', form).each(function(){
			var input = $('[name="'+$(this).attr("data-display")+'"]', form);

			if (input.is(":text") || input.is("textarea")) {
				$(this).html(input.val());
			} else if (input.is("select")) {
				$(this).html(input.find('option:selected').text());
			} else if (input.is(":radio") && input.is(":checked")) {
				$(this).html(input.attr("data-title"));
			}
		});
	}

	var handleTitle = function(tab, navigation, index) {
		var total = navigation.find('li').length;
		var current = index + 1;

		// Set widget title
		$('.step-title', wizard).text('Step ' + (index + 1) + ' of ' + total);

		// Set done steps
		$('li', wizard).removeClass("done");

		var li_list = navigation.find('li');
		for (var i = 0; i < index; i++) {
			$(li_list[i]).addClass("done");
		}

		if (current == 1) {
			wizard.find('.button-previous').hide();
		} else {
			wizard.find('.button-previous').show();
		}

		if (current >= total) {
			wizard.find('.button-next').hide();
			wizard.find('.button-submit').show();
			displayConfirm();
		} else {
			wizard.find('.button-next').show();
			wizard.find('.button-submit').hide();
		}
	}

	// Form wizard example
	wizard.bootstrapWizard({
		'nextSelector': '.button-next',
		'previousSelector': '.button-previous',
		'currTab': null,
		'currNav': null,
		'currIndex': null,
		onTabClick: function (tab, navigation, index, clickedIndex) {
			success.hide();
			error.hide();

			if (form.valid() == false) {
				return false;
			}
			
			console.log ('onTabClick tab: ' + tab + ' navigation: ' + navigation + ' index: ' + index + ' clickedIndex: ' + clickedIndex);

			handleTitle(tab, navigation, clickedIndex);
		},
		onNext: function (tab, navigation, index) {
			success.hide();
			error.hide();

			if (form.valid() == false) {
				return false;
			}
			
			console.log ('onNext tab: ' + tab + ' navigation: ' + navigation + ' index: ' + index);
			
			this.currTab = tab; this.currNav = navigation; this.currIndex = index;			
			this.postData(tab, index);
			
			handleTitle(this.currTab, this.currNav, this.currIndex);
			
			return false;

		},
		onPrevious: function (tab, navigation, index) {
			success.hide();
			error.hide();

			handleTitle(tab, navigation, index);
		},
		onTabShow: function (tab, navigation, index) {
			// To set progressbar width
			var total = navigation.find('li').length;
			var current = index + 1;
			var $percent = (current / total) * 100;
			wizard.find('.progress-bar').css({
				width: $percent + '%'
			});
		},
		postData: function (tab, index)
		{
			console.log ('tab: ' + tab + ' index: ' + index);
			// var itemManager = FuseApp.getManager('Item').create('user', form, this);
			FuseApp.getManager('data').sendData(form.find('#tab' + index), form.find('#tab' + index + ' :input'), this, 'returnData');
			
		},
		returnData: function (data)
		{
			console.log ('returnData: ' + data + ' success: ' + data.success);
			if (data.success) 
			{
				if (this.warning != null) this.warning.close();
				$('#form_wizard').find('li:has([data-toggle="tab"])' + ':eq('+(this.currIndex)+') a').tab('show');
				
				if (data.newPIN != null) 
				{
					$('#userHeader .userPIN').html('(PIN: ' + data.newPIN + ')');
					$('#userHeader').removeClass('lead').addClass('account');
				}
			}
			else 
			{
				this.warning = $('#content .tab-pane.active').noty({type: 'warning', text: data.errorMessage});
				$('#tab3 .form-group.pin').removeClass('has-success').addClass('has-error');
			}
			
		} 
		
	});

	wizard.find('.button-previous').hide();
	$('#form_wizard .button-submit').click(function () {
		alert('You just finished the wizard. :-)');
		form.submit();
	}).hide();

	
	$('#form_wizard #samePostal').change(function () {
		
		console.log ('isOn: ' + $(this).val());
		
		if ($(this).val() == 1)  $('div#postAddress').addClass('hidden');
		else $('div#postAddress').removeClass('hidden');
	})
	
	if ($('#form_wizard #samePostal').val() == 1)  $('div#postAddress').addClass('hidden');
	else $('div#postAddress').removeClass('hidden');	
	


});