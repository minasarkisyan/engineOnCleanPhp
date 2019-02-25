<div class="main">
	<?=$hornav?>
	<h1>Поиск: <?=$query?></h1>
	<?php if ($error_len) { ?><p class="message">Слишком короткий поисковый запрос!</p><?php } ?>
	<div id="search_result">
		<p>Что искали: <b><?=$query?></b></p>
		<p>Всего найдено: <b><?=count($data)?></b> записей</p>
		<?php $number = 0; foreach ($data as $d) { $number++; ?>
			<div class="search_item">
				<div class="article_info">
					<ul>
						<li><?=$number?>. <a href="<?=$d->link?>"><?=$d->title?></a></li>
						<?php if (isset($d->section) || isset($d->category)) { ?>
							<li><?=$d->section->title?><?php if ($d->category) { ?>/<?=$d->category->title?><?php } ?></li>
						<?php } ?>
					</ul>
					<div class="clear"></div>
				</div>
				<div class="search_text"><?=$d->description?></div>
			</div>
		<?php } ?>	
	</div>
</div>