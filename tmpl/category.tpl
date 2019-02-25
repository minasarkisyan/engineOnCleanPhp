<div class="main">
	<?php if (count($articles)) { ?>
		<?php $number = 0; foreach ($articles as $article) { $number++; ?>
			<div class="category_item">
				<div><?=$number?>. <a href="<?=$article->link?>"><?=$article->title?></a></div>
				<div class="category_author">
					<img src="/images/icon_user.png" alt="" /> Михаил Русаков</div>
				<div class="clear"></div>
			</div>
		<?php } ?>
	<?php } else { ?>
		<h2>Материалов пока нет.</h2>
	<?php } ?>
</div>