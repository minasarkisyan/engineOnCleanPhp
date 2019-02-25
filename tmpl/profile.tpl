<div class="main">
	<?php if (isset($hornav)) { ?><?=$hornav?><?php } ?>	
	<div id="profile">
		<h1>Изменить аватар</h1>
		<div class="center">
			<img src="<?=$avatar?>" alt="Аватар" />
		</div>
		<div class="avatar_info">
			<p>Допустимые форматы - <b>GIF</b>, <b>JPG</b>, <b>PNG</b></p>
			<p>Размер изображения должен быть <b>не более <?=$max_size?> КБ</b>!</p>
			<p>Изображение должно быть квадратным (иначе могут не соблюдаться пропорции)!</p>
		</div>
		<?=$form_avatar?>
		<?=$form_name?>
		<?=$form_password?>
	</div>
</div>