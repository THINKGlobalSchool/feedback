<?php
/**
 * The status on the admin menu bar
 */

$entity = elgg_extract('entity', $vars);
$id = 'feedback-' . $entity->getGUID();

echo "<label class=\"mrs\" for=\"$id\">" . elgg_echo('feedback:status') . ':</label>';
echo elgg_view('input/dropdown', array(
	'name' => 'status',
	'value' => $entity->status,
	'options_values' => feedback_get_status_types(),
	'id' => $id
));