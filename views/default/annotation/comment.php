<?php
/**
 * Feedback Comments, 
 * Slighlty modified version of the elgg generic_comment view
 *
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson & Curverider Ltd
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */
$owner = get_user($vars['annotation']->owner_guid);

?>
<a class="anchor_link" name="comment_<?php echo $vars['annotation']->id; ?>"></a>
<div class="generic_comment clearfloat">
	<div class="generic_comment_icon">
		<?php
			echo elgg_view("profile/icon", array(
					'entity' => $owner,
					'size' => 'tiny'
					));
		?>
	</div>

	<div class="generic_comment_details">
		<?php
		// if the user looking at the comment can edit, show the delete link
		if ($vars['annotation']->canEdit()) {
		?>
			<span class="delete_button">
				<?php echo elgg_view("output/confirmlink",array(
						'href' => $vars['url'] . "action/comments/delete?annotation_id=" . $vars['annotation']->id,
						'text' => elgg_echo('delete'),
						'confirm' => elgg_echo('deleteconfirm')
						));
				?>
			</span>
		<?php
			} //end of can edit if statement
		?>
		<p class="generic_comment_owner">
			<a href="<?php echo $owner->getURL(); ?>"><?php echo $owner->name; ?></a>
			<span class="entity_subtext">
				<?php echo friendly_time($vars['annotation']->time_created); ?>
			</span>
		</p>
		<!-- output the actual comment -->
		<div class="generic_comment_body">
		
		<?php 
			
			if (is_array($comment = unserialize($vars['annotation']->value))) {
				
				$feedbackvote = '';
				if ($comment['feedbackvote'] == 1) {
					$feedbackvote = "<div id='feedbackvote'><img src='" . $vars['url'] . "mod/feedback/images/like.png' /> <span>" . elgg_echo("feedback:update:like") . "</span></div>";
				} else if ($comment['feedbackvote'] == 0) {
					$feedbackvote = "<div id='feedbackvote'><img src='" . $vars['url'] . "mod/feedback/images/dislike.png' /> <span>" . elgg_echo("feedback:update:dislike") . "</span></div>";
				}
				
				
				echo "<br />" . $feedbackvote;
				echo elgg_view("output/longtext",array("value" => $comment['comment']));

			} else {
				echo elgg_view("output/longtext",array("value" => $vars['annotation']->value)); 
			}
		?>
		</div>
	</div>
</div>