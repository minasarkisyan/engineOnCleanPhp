<?php if (isset($hornav)) { ?>
	<div class="main">
		<?=$hornav?>
<?php } ?>
<?php if ($header) { ?><h1><?=$header?></h1><?php } ?>
<?php if ($message) { ?><p class="message"><?=$message?></p><?php } ?>
<div class="form">
	<div <?php if ($name) { ?>id="<?=$name?>"<?php } ?>>
		<form <?php if ($name) { ?>name="<?=$name?>"<?php } ?> action="<?=$action?>" method="<?=$method?>" <?php if ($check) { ?>onsubmit="return checkForm(this)"<?php } ?> <?php if ($enctype) { ?>enctype="<?=$enctype?>"<?php } ?>>
			<?php foreach ($inputs as $input) { ?>
				<?php include "f_".$input->type.".tpl"; ?>
			<?php } ?>
		</form>
	</div>
</div>
<?php if (isset($hornav)) { ?></div><?php } ?>