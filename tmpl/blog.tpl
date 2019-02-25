<div class="main">
	<h2 class="h1">Свежие статьи</h2>
	<?php foreach ($articles as $article) { ?>
		<section>
			<div class="article_img">
				<img src="<?=$article->img?>" alt="<?=$article->title?>" />
				<div>
					<img class="date_img" src="/images/date.png" alt="" />
					<div class="date_text"><?=$article->day_show?><br /><?=$article->month_show?></div>
				</div>
			</div>
			<h2><?=$article->title?></h2>
			<?=$article->intro?>
			<div class="clear"></div>
			<a class="more" href="<?=$article->link?>">Прочитать</a>
			<br />
			<div class="article_info">
				<ul>
					<li>
						<img src="/images/icon_user.png" alt="" />
					</li>
					<li>Михаил Русаков</li>
					<li><?=$article->count_comments?> <?=$article->count_comments_text?></li>
					<?php if ($article->section) { ?>
						<li>
							<a href="<?=$article->section->link?>"><?=$article->section->title?></a>
						</li>
					<?php } ?>
					<?php if ($article->category) { ?>
						<li>
							<a href="<?=$article->category->link?>"><?=$article->category->title?></a>
						</li>
					<?php } ?>
				</ul>
				<div class="clear"></div>
			</div>
		</section>
	<?php } ?>
	<?php if ($more_articles) { ?>
		<hr />
		<h3>Ещё статьи...</h3>
		<ul>
			<?php foreach ($more_articles as $article) { ?>
				<li>
					<a href="<?=$article->link?>"><?=$article->title?></a>
				</li>
			<?php } ?>
		</ul>
	<?php } else { ?>
		<?=$pagination?>
	<?php } ?>
</div>