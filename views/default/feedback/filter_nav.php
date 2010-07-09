<div class="">
	<div class="elgg_horizontal_tabbed_nav margin_top">
		<center>
		<ul>
		<?php 
			echo "<li class='" . (($vars['status'] == null) ? 'selected ' : '') . " edt_tab_nav'>" . elgg_view('output/url', array('href' => $vars['url'] . $vars['page'], 'text' => elgg_echo("All"), 'class' => 'feedback')) . "</li>"; 
			foreach (get_status_types() as $type) {
				// Duplicate hidden for now
				if ($type == "duplicate")
					continue;
				echo "<li class='" . (($vars['status'] == $type) ? 'selected ' : '') . "edt_tab_nav'>" . elgg_view('output/url', array('href' => $vars['url'] . $vars['page'] . "?status=" . $type, 'text' => elgg_echo("feedback:status:" . strtolower($type)), 'class' => 'feedback')) ."</li>"; 
			}	
		?>
		</ul>
		</center>
		
	</div>
</div>