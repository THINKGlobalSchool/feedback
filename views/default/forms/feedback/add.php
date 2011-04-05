<?php
/**
 * Add feedback form
 */

// default values. Overwritten for a sticky form
$values = array(
	'mood' => 'neutral',
	'about' => 'suggestions',
	'title' => elgg_echo('feedback:default:title'),
	'id' => elgg_echo('feedback:default:id'),
	'description' => elgg_echo('feedback:default:txt')
);

if (elgg_is_sticky_form('feedback')) {
	$values = elgg_get_sticky_values('feedback');
	elgg_clear_sticky_form('feedback');
}

$message = elgg_view('output/longtext', array(
	'value' => elgg_echo('feedback:message')
));

$mood_label = elgg_echo('feedback:list:mood');

$mood = elgg_view('input/radio', array(
	'name' => 'mood',
	'options' => array(
		elgg_echo('feedback:mood:angry') => 'angry',
		elgg_echo('feedback:mood:neutral') => 'neutral',
		elgg_echo('feedback:mood:happy') => 'happy'
	),
	'value' => $values['mood'],
	'align' => 'horizontal'
));

$about_label = elgg_echo('feedback:list:about');

// can't use this because we need to manually break after 3 options :(
//$about = elgg_view('input/radio', array(
//	'name' => 'about',
//	'options' => array(
//		'bug_report' => elgg_echo('feedback:about:bug_report'),
//		'content' => elgg_echo('feedback:about:content'),
//		'suggestions' => elgg_echo('feedback:about:suggestions'),
//		'compliment' => elgg_echo('feedback:about:compliment'),
//		'other' => elgg_echo('feedback:about:other'),
//	),
//	'value' => 'suggestions',
//	'align' => 'horizontal'
//));

$about = '';
$options = array('bug_report', 'content', 'suggestions', 'compliment', 'other');
foreach ($options as $option) {
	$label = elgg_echo("feedback:about:$option");
	$checked = $br = '';

	if ($option == $values['about']) {
		$checked = 'checked="checked"';
	}

	if ($option == 'suggestions') {
		$br = '<br />';
	}
	$about .= "<label class=\"mrm\"><input class=\"mrm\" type=\"radio\" name=\"about\" value=\"$option\" $checked/>$label</label>$br";
}

$title = elgg_view('input/text', array(
	'name' => 'title',
	'value' => $values['title'],
	'class' => 'mbm elgg-feedback-default-value'
));

$user = elgg_get_logged_in_user_entity();
if ($user) {
	$feedback_id_default = "$user->name ($user->email)";
	$disabled = 'disabled';
	$class = '';
} else {
	$feedback_id_default = $values['id'];
	$disabled = '';
	$class = 'elgg-feedback-default-value';
}

$id = elgg_view('input/text', array(
	'name' => 'id',
	'value' => $feedback_id_default,
	'disabled' => $disabled,
	'class' => "mbm $class"
));

$feedback = elgg_view('input/plaintext', array(
	'name' => 'description',
	'value' => $values['description'],
	'class' => 'mbm elgg-feedback-default-value'
));

// logged out requires captchas
if (!$user) {
	$captcha = elgg_view('input/captcha');
} else {
	$captcha = '';
}

$note = elgg_view('output/longtext', array(
	'value' => elgg_echo('feedback:search_note', array(elgg_get_site_url() . 'feedback/all')),
	'class' => 'mbm'
));

$send = elgg_view('input/submit', array(
	'value' => elgg_echo('send')
));

$cancel = elgg_view('input/reset', array(
	'value' => elgg_echo('cancel')
));


echo <<<___HTML
	$message

	<label class="prm left">$mood_label:</label>
	$mood
	<div class="clearfloat"></div>

	<label class="prm left">$about_label:</label>
	<div class="left">$about</div>
	<div class="clearfloat"></div>

	$title
	$id
	$feedback

	$captcha

	$note
	$send
	$cancel
___HTML;
?>