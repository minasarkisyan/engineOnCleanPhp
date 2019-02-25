<div>
	<label for="<?=$input->name?>"><?=$input->label?></label>
	<input id="<?=$input->name?>" type="text" name="<?=$input->name?>" value="<?=$input->value?>" placeholder="<?=$input->default_v?>" <?php include "jsv.tpl"; ?> />
</div>