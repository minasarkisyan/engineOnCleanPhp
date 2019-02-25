<?php foreach ($courses as $course) { ?>
	<div class="block">
		<div class="header"><?=$course->header?></div>
		<div class="content">
			<div class="free">
				<p class="title"><?=$course->sub_header?></p>
				<a rel="external" href="<?=$course->link?>">
					<img src="<?=$course->img?>" alt="<?=$course->title?>" />
				</a>
				<?=$course->text?>
				<?php if ($course->did) { ?>
					<p class="center"><b>Чтобы получить Видеокурс,<br />заполните форму</b></p>
					<form name="free_course" action="http://smartresponder.ru/subscribe.html" method="post" onsubmit="return SR_submit(this)">
						<table>
							<tr>
								<td>
									<label for="field_email">E-mail:</label>
								</td>
								<td>
									<input id="field_email" type="text" name="field_email" value="<?php if ($auth_user) { ?><?=$auth_user->email?><?php } ?>" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="field_name_first">Имя:</label>
								</td>
								<td>
									<input id="field_name_first" type="text" name="field_name_first" value="<?php if ($auth_user) { ?><?=$auth_user->name?><?php } ?>" />
								</td>
							</tr>
							<tr>
								<td colspan="2" class="center">
									<input type="hidden" value="1" name="version">
									<input type="hidden" value="187271" name="tid">
									<input type="hidden" value="85884" name="uid">
									<input type="hidden" value="ru" name="lang">
									<input type="hidden" value="<?=$course->did?>" name="did[]">
									<input type="submit" name="free_course" value="Получить курс" class="button" />
								</td>
							</tr>
						</table>
					</form>
				<?php } else { ?>
					<div class="center">
						<a href="<?=$course->link?>" class="button">Записаться</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>