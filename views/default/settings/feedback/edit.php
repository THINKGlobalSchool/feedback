<?php
/**
 * Settings page for feedback.
 */

$settings = $vars['entity'];
$enable_river = $settings->enableriver;

$admin_users = array(
	1 => $settings->user_1,
	2 => $settings->user_2,
	3 => $settings->user_3,
	4 => $settings->user_4,
	5 => $settings->user_5,
);

$disable_public = elgg_view('input/dropdown', array(
	'name' => 'params[disablepublic]',
	'option_values' => array(
		'1' => elgg_echo('yes'),
		'0' => elgg_echo('no')
	),
	'value' => (int)$settings->disablepublic
));

// currently unavailable
$disable_public = '';

$enable_river = elgg_view('input/dropdown', array(
	'name' => 'params[enableriver]',
	'options_values' => array(
		'1' => elgg_echo('option:yes'),
		'0' => elgg_echo('option:no')
	),
	'value' => (int)$settings->enableriver
));

$admin_users_input = '<ol>';
foreach ($admin_users as $i => $user) {
	$admin_users_input .= '<li>';
	$admin_users_input .= elgg_view('input/text', array(
		'name' => "params[user_$i]",
		'value' => $user
	));
	$admin_users_input .= '</li>';
}
$admin_users_input .= '</ol>';

// @todo anonymous feedback disabled currently
/*
<label>
	echo elgg_echo('feedback:settings:disablepublic');
	echo $disable_public;
</label>
*/
?>

<label><?php
	echo elgg_echo('feedback:settings:riverdisplay');
	echo $enable_river;
?></label>

<?php
	echo '<label>' . elgg_view('output/longtext', array('value' => elgg_echo('feedback:settings:admin_users'))) . '</label>';
	echo $admin_users_input;
?>

