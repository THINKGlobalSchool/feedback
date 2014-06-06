<?php
/**
 * Feedback status input
 * 
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 * 
 */

// Get status types
$status_types = feedback_get_status_types();

// Add an 'any' item
$status_id = get_input('feedback_status_id', 'any');

// Start building status array
$status_values = array('any' => elgg_echo('feedback:status:any'));

foreach ($status_types as $id => $status) {
	$status_values[$id] = $status;
}

echo "<label class='mlm'>" . elgg_echo('feedback:status') . ": </label>";
echo elgg_view('input/dropdown', array(
	'name' => 'feedback_status',
	'id' => 'feedback-status-filter',
	'options_values' => $status_values,
	'value' => get_input('feedback_status_id')
));