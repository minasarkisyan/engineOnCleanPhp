<div class="main">
	<?=$hornav?>
	<?php if ($message) { ?><p class="message"><?=$message?></p><?php } ?>
	<h1><?=$title?></h1>
	<div id="poll_result">
		<?php foreach ($data as $d) { ?>
			<div>
				<p><?=$d->title?></p>
				<div class="poll_result" style="width: <?=$d->percent?>%;"><?=$d->voters?></div>
				<p class="poll_percent"><?=$d->percent?>%</p>
			</div>
			<div class="clear"></div>
		<?php } ?>
		<br />
		<p>Общее количество голосов: <b><?=$count_voters?></b></p>
	</div>
</div>