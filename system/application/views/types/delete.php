<p>Are you sure you want to delete the type <strong><?= $type->name ?></strong>?</p>
<form action="<?= current_url() ?>" method="post">
	<p>
		<input type="submit" name="deleteok" value="Yes, Delete the type" />
		<input type="submit" name="cancel" value="Cancel" />
	</p>
</form>
