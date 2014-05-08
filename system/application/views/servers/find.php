<div class="intro">
<?php
$t = new Type();
$t->get_by_name("$type");
echo $t->intro; 
?>
</div>
<?php echo $table; ?>
<div id="box" style="display:none; cursor: default"> 
<div id="resText" ></div>
<input type="button" id="close" value="close" />
</div> 
<div id="wait" style="display:none;"> 
<h4><img src="<?= str_replace('ttms/', 'web/ttms/', site_url('img/busy.gif')) ?>" /> Please wait for the action complete :)</h4> 
</div> 
