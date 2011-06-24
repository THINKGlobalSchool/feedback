<?php
/**
 * Feedback created river view
 * 
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$object = $vars['item']->getObjectEntity();
$excerpt = strip_tags($object->txt);

echo elgg_view('river/item', array(
	'item' => $vars['item'],
	'message' => $excerpt,
));