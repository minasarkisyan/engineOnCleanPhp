<?php
	$count_pages = ceil($count_elements / $count_on_page);
	if ($count_pages > 1) {
		$left = $active - 1;
		$right = $count_pages - $active;
		if ($left < floor($count_show_pages / 2)) $start = 1;
		else $start = $active - floor($count_show_pages / 2);
		$end = $start + $count_show_pages - 1;
		if ($end > $count_pages) {
			$start -= ($end - $count_pages);
			$end = $count_pages;
			if ($start < 1) $start = 1;
		}
?>
	<div id="pagination">
		<?php if ($active != 1) { ?>
			<a href="<?=$url?>" title="Первая">Первая</a>
			<a href="<?php if ($active == 2) { ?>$url<?php } else { ?><?=$url_page.($active - 1)?><?php } ?> title="Предыдущая">Предыдущая</a>
		<?php } else { ?>
			<span>Первая</span>
			<span>Предыдущая</span>
		<?php } ?>
		<?php for ($i = $start; $i <= $end; $i++) { ?>
			<?php if ($i == $active) { ?><span><?=$i?></span><?php } else { ?><a href="<?php if ($i == 1) { ?><?=$url?><?php } else { ?><?=$url_page.$i?><?php } ?>"><?=$i?></a><?php } ?>
		<?php } ?>
		<?php if ($active != $count_pages) { ?>
			<a href="<?=$url_page.($active + 1)?>" title="Следующая">Следующая</a>
			<a href="<?=$url_page.$count_pages?>" title="Последняя">Последняя</a>		
		<?php } else { ?>
			<span>Следующая</span>
			<span>Последняя</span>
		<?php } ?>			
	</div>
<?php } ?>