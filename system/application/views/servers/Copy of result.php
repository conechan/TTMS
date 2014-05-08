<html>
<head>
    <script src="<?= str_replace('ttms/', 'web/ttms/', site_url('js/jquery.js')) ?>" type="text/javascript"></script>
    <script src="<?= str_replace('ttms/', 'web/ttms/', site_url('js/jquery.blockUI.js')) ?>" type="text/javascript"></script>
    <script src="<?= str_replace('ttms/', 'web/ttms/', site_url('js/action.ajax.js')) ?>" type="text/javascript"></script>
</head>
<body>
<div class="result">
<h3>Action Result</h3>
<pre>
<?php
echo $result;
?>
</pre>
</div>
</body>
</html>
