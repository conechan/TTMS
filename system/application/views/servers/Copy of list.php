<?php echo $table; ?>
<br />
<?php echo $pagination; ?>
<br />
<p>
<?php echo anchor('servers/add/','Add new server', 'class="add"'); ?>
</p>
<p>
<?php echo anchor('admin','Back to Admin', 'class="back"'); ?>
</p>
<div id="box" style="display:none; cursor: default"> 
<div id="resText" ></div>
<input type="button" id="close" value="close" />
</div> 
<div id="wait" style="display:none;"> 
<h4><img src="<?= str_replace('ttms/', 'web/ttms/', site_url('img/busy.gif')) ?>" /> Please wait for the action complete :)</h4> 
</div> 
