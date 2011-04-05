<?php
/**
 * Feedback updated river view
 * 
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

// pass through create with a different text.
$vars['text_key'] = 'feedback:river:update';
echo elgg_view('river/object/feedback/create', $vars);