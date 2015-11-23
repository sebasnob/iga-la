/*---LEFT BAR ACCORDION----*/
$(function() {
    $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: true,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
//        cookie: 'dcjq-accordion-1',
        classExpand: 'dcjq-current-parent'
    });
});

var Script = function () {


//    sidebar dropdown menu auto scrolling

    jQuery('#sidebar .sub-menu > a').click(function () {
        var o = ($(this).offset());
        diff = 250 - o.top;
        if(diff>0)
            $("#sidebar").scrollTo("-="+Math.abs(diff),500);
        else
            $("#sidebar").scrollTo("+="+Math.abs(diff),500);
    });



//    sidebar toggle

    $(function() {
        function responsiveView() {
            var wSize = $(window).width();
            if (wSize <= 768) {
                $('#container').addClass('sidebar-close');
                $('#sidebar > ul').hide();
            }

            if (wSize > 768) {
                $('#container').removeClass('sidebar-close');
                $('#sidebar > ul').show();
            }
        }
        $(window).on('load', responsiveView);
        $(window).on('resize', responsiveView);
    });

    $('.fa-bars').click(function () {
        if ($('#sidebar > ul').is(":visible") === true) {
            $('#main-content').css({
                'margin-left': '0px'
            });
            $('#sidebar').css({
                'margin-left': '-210px'
            });
            $('#sidebar > ul').hide();
            $("#container").addClass("sidebar-closed");
        } else {
            $('#main-content').css({
                'margin-left': '210px'
            });
            $('#sidebar > ul').show();
            $('#sidebar').css({
                'margin-left': '0'
            });
            $("#container").removeClass("sidebar-closed");
        }
    });

// custom scrollbar
    $("#sidebar").niceScroll({styler:"fb",cursorcolor:"#4ECDC4", cursorwidth: '3', cursorborderradius: '10px', background: '#404040', spacebarenabled:false, cursorborder: ''});

    $("html").niceScroll({styler:"fb",cursorcolor:"#4ECDC4", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});

// widget tools

    jQuery('.panel .tools .fa-chevron-down').click(function () {
        var el = jQuery(this).parents(".panel").children(".panel-body");
        if (jQuery(this).hasClass("fa-chevron-down")) {
            jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200);
        }
    });

    jQuery('.panel .tools .fa-times').click(function () {
        jQuery(this).parents(".panel").parent().remove();
    });


//    tool tips

    $('.tooltips').tooltip();

//    popovers

    $('.popovers').popover();



// custom bar chart

    if ($(".custom-bar-chart")) {
        $(".bar").each(function () {
            var i = $(this).find(".value").html();
            $(this).find(".value").html("");
            $(this).find(".value").animate({
                height: i
            }, 2000)
        })
    }
    
    
    
    $('#logout').click(function(){
        $.ajax({
            type: "POST", 
            url: "logout.php",  
            data: {logout:'logout'},
            success:function(){
                window.location = 'login.php';
            }
        });
    });


}();

$('#buscarGrilla').click(function()
{
    var url = "grilla_edit.php?accion=filtrar";
    
    if($('#id_curso_filtro').val() != 0)
    {
        url += '&id_curso_filtro=' + $('#id_curso_filtro').val();
    }
    if($('#pais_filtro').val() != 0)
    {
        url += '&pais_filtro=' + $('#pais_filtro').val();
    }
    if($('#idioma_filtro').val() != 0)
    {
        url += '&idioma_filtro=' + $('#idioma_filtro').val();
    }
    if($('#tipo_filtro').val() != 0)
    {
        url += '&tipo_filtro=' + $('#tipo_filtro').val();
    }
    if($('#habilitado_filtro').val() != 3)
    {
        url += '&habilitado_filtro=' + $('#habilitado_filtro').val();
    }

    window.location.href = url;
    
});


(function($) {  
                $.get = function(key)   {  
                    key = key.replace(/[\[]/, '\\[');  
                    key = key.replace(/[\]]/, '\\]');  
                    var pattern = "[\\?&]" + key + "=([^&#]*)";  
                    var regex = new RegExp(pattern);  
                    var url = unescape(window.location.href);  
                    var results = regex.exec(url);  
                    if (results === null) {  
                        return null;  
                    } else {  
                        return results[1];  
                    }  
                }  
            })(jQuery); 