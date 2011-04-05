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
$excerpt = elgg_get_excerpt($object->txt);
$text_key = elgg_extract('text_key', $vars, 'feedback:river:create');

$params = array(
	'href' => $object->getURL(),
	'text' => $object->title,
);
$link = elgg_view('output/url', $params);
echo elgg_echo($text_key, array($link));

if ($excerpt) {
	echo '<div class="elgg-river-content">';
	echo $excerpt;
	echo '</div>';
}