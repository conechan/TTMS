<script src="<?= str_replace('ttms/', 'web/ttms/', site_url('js/cle/jquery.cleditor.min.js')) ?>" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?= str_replace('ttms/', 'web/ttms/', site_url('js/cle/jquery.cleditor.css')) ?>" />
<script type="text/javascript">
    $(document).ready(function() {
        $("#intro").cleditor();
      });
</script>
<?=$type->render_form($form_fields, $url);?>
<p>
<?=anchor('types/','back to the list', 'class="back"')?>
</p>
