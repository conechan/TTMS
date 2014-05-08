    $(document).ajaxStop(function() {
        $.blockUI({
         message: $('#box'),
            css: { 
                top:  ($(window).height() - 500) /2 + 'px', 
                left: ($(window).width() - 500) /2 + 'px', 
                width: '500px' 
            } 
         
        });    
    });

    function retext() {
        var p = {};

        $("#resText").load('/servers/execute .result',p,function(str));
    }

    $(document).ready(function() {
	    $(".send").click(function() {
            $.blockUI({ message: $('#wait') });
			retext();
	    });
        $('#close').click(function() { 
            $.unblockUI(); 
            return false; 
        });      
    });

