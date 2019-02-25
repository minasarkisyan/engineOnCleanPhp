<nav>
	<ul id="topmenu">
		<?php foreach ($items as $item) { ?>
			<li>
				<a <?php if ($item->link == $uri) { ?>class="active"<?php } ?> <?php if ($item->external) { ?>rel="external"<?php } ?> href="<?=$item->link?>"><?=$item->title?></a>
			</li>
		<?php } ?>
	</ul>
</nav>