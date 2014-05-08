$(document).ready (
  function () {
    $(".send").click (
      function () {
        alert($(this).attr("ip"));
        alert($(this).attr("command"));
        alert($(this).attr("h_name"));
      }
    );
  }
);
