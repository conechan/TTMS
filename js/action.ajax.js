$(document).ready (
  function () {
    $(".send").click (
      function () {
        alert($(this).attr("ip"));
        alert($(this).attr("command"));
        alert($(this).attr("h_name"));
        $("#resText").load("<?php echo site_url();?>/servers/execute/137.117.36.94/ls");
      }
    );
  }
);
