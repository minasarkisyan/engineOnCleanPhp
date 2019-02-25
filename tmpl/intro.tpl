<div class="main">
	<?php if (isset($hornav)) { ?><?=$hornav?><?php } ?>
	<article>
		<h1><?=$obj->title?></h1>				
		<div class="article_img">
			<img src="<?=$obj->img?>" alt="<?=$obj->title?>">
		</div>
		<?=$obj->description?>
	</article>
</div>