<?php
/**
 * Feedback plugin js
 */
?>
//<script>
elgg.provide('elgg.feedback');

elgg.feedback.init = function() {
	// custom popup positioning and effects
	elgg.register_hook_handler('getOptions', 'ui.popup', elgg.feedback.popupSetup);

	// form buttons
	$('#elgg-feedback-wrapper input[type=submit]').live('click', elgg.feedback.submit);
	$('#elgg-feedback-wrapper input[type=reset]').live('click', elgg.feedback.reset);

	// store default values, clear on focus, restore on blur
	elgg.feedback.setDefaultValues();

	// set status for admin control panel
	$('.elgg-feedback-entity-wrapper select').live('change', elgg.feedback.setStatus);
}

/**
 * Sets default values for forms
 **/
elgg.feedback.setDefaultValues = function() {
	// save the default values as data and register functions
	// to clear / restore it.
	$('.elgg-feedback-default-value')
		.die('blur', elgg.feedback.restoreDefaultValue)
		.die('focus', elgg.feedback.clearDefaultValue)
		.live('blur', elgg.feedback.restoreDefaultValue)
		.live('focus', elgg.feedback.clearDefaultValue)
		.each(function(i, el) {
			if (!$(el).data('defaultValue')) {
				$(el).data('defaultValue', $(el).val());
			}
		});
}

/**
 * Position the popup better and provide animation
 *
 * This overrides the default popup.
 */
elgg.feedback.popupSetup = function(hook, type, params, options) {
	if (params.targetSelector == '#elgg-feedback-wrapper') {
		var $target = params.target;
		
		// hide if already open
		if ($target.is(':visible')) {
			$target.hide('slide', {direction: 'left'}, 200)
			return;
		}

		// add padding the width of the popper
		var posL = params.source.outerWidth();

		options.my = 'left top';
		options.at = 'left top';
		options.collision = 'none';
		options.offset = posL + ' 0';

		// @hack jQuery can't get the position of hidden elements, so jquery UI can't
		// position them. We solve that by positioning this element offscreen
		$target
			.css('margin-left', posL + 'px')
			.css('display', 'block')
			.position(options)
			.show('slide', {direction: 'left'}, 200);

		return false;
	}
	
	return options;
}

/**
 * Sets the default value if the value is ''
 */
elgg.feedback.restoreDefaultValue = function() {
	var $this = $(this);
	if ($this.val() == '') {
		$this.val($this.data('defaultValue'));
	};
}

/**
 * Clears the input if the value is the default value
 */
elgg.feedback.clearDefaultValue = function() {
	var $this = $(this);
	if ($this.val() == $this.data('defaultValue')) {
		$this.val('');
	};
}

/**
 * Submits via ajax
 */
elgg.feedback.submit = function(e) {
	e.preventDefault();

	var $this = $(this);
	var $form = $this.closest('form');
	var action = $form.attr('action');
	var $container = $this.closest('.elgg-body');
	var w = $container.outerWidth();
	var h = $container.outerHeight();

	// hide the form with a progress bar
	$container.html('<span class="elgg-ajax-loader"></span>').width(w).height(h);

	// gives a thanks message if works, shows the form again if fails.
	elgg.action(action, {
		data: $form.serialize(),
		success: function(json) {
			$container.html(json.output);
			// don't put the default value things here because
			// it will clear the user input!
			// @todo use a different field than value (title, perhaps?)

			// close the feedback on success
			if (json.status >= 0) {
				$('a.elgg-feedback').click();
			}

			elgg.feedback.setDefaultValues();
		}
	});
}

/**
 * Closes the slide out, but doesn't reset the form
 */
elgg.feedback.reset = function(e) {
	e.preventDefault();

	$('a.elgg-feedback').click();
}

/**
 * Sets the status of the feedback
 */
elgg.feedback.setStatus = function(e) {
	var $this = $(this);
	var data = {
		guid: $this.attr('id').split('-')[1],
		status_id: $this.val()
	}

	elgg.action('feedback/set_status', {
		'data': data,
		'success': function(json) {
			var pageStatusID = elgg.feedback.getActiveStatusID();
			if (pageStatusID && (pageStatusID != data.status_id)) {
				$this.closest('.elgg-feedback-entity-wrapper').fadeOut();
			}
		}
	});
}

/**
 * Returns the status of the current
 */
elgg.feedback.getActiveStatusID = function() {
	var url = window.location.href;
	var regex = new RegExp("[\\?&]feedback_status_id=([^&#]*)");
	
	var results = regex.exec(url);
	if (results) {
		return results[1];
	}
	return false;
}

elgg.register_hook_handler('init', 'system', elgg.feedback.init);