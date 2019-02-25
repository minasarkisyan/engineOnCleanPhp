<?php function printItem($item, &$items, $childrens, $active) { ?>
	<?php if (count($items) == 0) return; ?>
	<div>
		<a <?php if (in_array($item->id, $active)) { ?>class="active"<?php } ?> <?php if ($item->external) { ?>rel="external"<?php } ?> href="<?=$item->link?>"><?=$item->title?></a>
		<?php
			while(true) {
				$key = array_search($item->id, $childrens);
				if (!$key) break;
				unset($childrens[$key]);
		?>
		<?=printItem($items[$key], $items, $childrens, $active)?>
		<?php } ?>
	</div>
<?php unset($items[$item->id]); } ?>
<div class="block">
	<div class="header">Уроки и статьи</div>
	<div class="content">
		<nav>
			<?php foreach ($items as $item) { ?>
				<?=printItem($item, $items, $childrens, $active)?>
			<?php } ?>
		</nav>
	</div>
</div>