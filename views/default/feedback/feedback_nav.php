<div class="">
	<div class="elgg_horizontal_tabbed_nav margin_top">
		<center>
		<ul>
			<li class='<?php echo ($vars['selected'] == 'all' ? 'selected ' : ' ') ?>edt_tab_nav'>
				<?php echo elgg_view('output/url', array('href' => $vars['url'] . "pg/feedback/all", 'text' => elgg_echo("feedback:submenu:allfeedback"), 'class' => 'feedback')); ?>
			</li>
			<li class='<?php echo ($vars['selected'] == 'mine' ? 'selected ' : ' ') ?>edt_tab_nav'>
				<?php echo elgg_view('output/url', array('href' => $vars['url'] . "pg/feedback/", 'text' => elgg_echo("feedback:submenu:yourfeedback"), 'class' => 'feedback')); ?>
			</li>
		</ul>
		</center>
	</div>
</div>