<?php
/**
 * The status on the admin menu bar
 */

$entity = elgg_extract('entity', $vars);

echo '<label class="mrs">' . elgg_echo('feedback:list:about') . ':</label>';
echo elgg_echo("feedback:about:$entity->about");