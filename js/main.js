jQuery(function($) {


    //Preloader
    var preloader = $('.preloader');
    $(window).load(function(){
        preloader.remove();
    });

    //#main-slider
    var slideHeight = $(window).height();
    $('#home-slider .item').css('height',slideHeight);

    $(window).resize(function(){'use strict',
        $('#home-slider .item').css('height',slideHeight);
    });
	
    //#main-slider
    var slideHeight = $(window).height();
    $('#slider .item').css('height',slideHeight);

    $(window).resize(function(){'use strict',
        $('#slider .item').css('height',slideHeight);
    });

    //Scroll Menu
    $(window).on('scroll', function(){
        if( $(window).scrollTop()>1 ){
            $('.main-nav').addClass('navbar-fixed-top');
            $('.dropdown-menu').addClass('fondoTransparente');
            $('.dropdown-menu').removeClass('fondoSolido');
        } else {
            $('.main-nav').removeClass('navbar-fixed-top');
            $('.dropdown-menu').removeClass('fondoTransparente');
            $('.dropdown-menu').addClass('fondoSolido');
        }
    });
	
    // Navigation Scroll
    $(window).scroll(function(event) {
        //		Scroll();
    });

    //	$('.navbar-collapse ul li a').on('click', function() {  
    //		$('html, body').animate({scrollTop: $(this.hash).offset().top - 5}, 1000);
    //		return false;
    //	});

    // User define function
    function Scroll() {
        var contentTop      =   [];
        var contentBottom   =   [];
        var winTop      =   $(window).scrollTop();
        var rangeTop    =   200;
        var rangeBottom =   500;
        $('.navbar-collapse').find('.scroll a').each(function(){
            contentTop.push( $( $(this).attr('href') ).offset().top);
            contentBottom.push( $( $(this).attr('href') ).offset().top + $( $(this).attr('href') ).height() );
        })
        $.each( contentTop, function(i){
            if ( winTop > contentTop[i] - rangeTop ){
                $('.navbar-collapse li.scroll')
                        .removeClass('active')
                        .eq(i).addClass('active');			
            }
        })
    };

    $('#tohash').on('click', function(){
        $('html, body').animate({scrollTop: $(this.hash).offset().top - 5}, 1000);
        return false;
    });
	
    //Initiat WOW JS
    new WOW().init();
    //smoothScroll
    smoothScroll.init();
	
    // Progress Bar
    $('#about-us').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $.each($('div.progress-bar'),function(){
                $(this).css('width', $(this).attr('aria-valuetransitiongoal')+'%');
            });
            $(this).unbind('inview');
        }
    });

    //Countdown
    $('#features').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $(this).find('.timer').each(function () {
                var $this = $(this);
                $({ Counter: 0 }).animate({ Counter: $this.text() }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.ceil(this.Counter));
                    }
                });
            });
            $(this).unbind('inview');
        }
    });

    // Portfolio Single View
    $('#portfolio').on('click','.folio-read-more',function(event){
        event.preventDefault();
        var link = $(this).data('single_url');
        var full_url = '#portfolio-single-wrap',
        parts = full_url.split("#"),
        trgt = parts[1],
        target_top = $("#"+trgt).offset().top;

        $('html, body').animate({scrollTop:target_top}, 600);
        $('#portfolio-single').slideUp(500, function(){
            $(this).load(link,function(){
                $(this).slideDown(500);
            });
        });
    });

    // Close Portfolio Single View
    $('#portfolio-single-wrap').on('click', '.close-folio-item',function(event) {
        event.preventDefault();
        var full_url = '#portfolio',
        parts = full_url.split("#"),
        trgt = parts[1],
        target_offset = $("#"+trgt).offset(),
        target_top = target_offset.top;
        $('html, body').animate({scrollTop:target_top}, 600);
        $("#portfolio-single").slideUp(500);
    });

    // Contact form
    /*var form = $('#main-contact-form');
	form.submit(function(event){
		event.preventDefault();
		var form_status = $('<div class="form_status"></div>');
		$.ajax({
			url: $(this).attr('action'),
			beforeSend: function(){
				form.prepend( form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Email is sending...</p>').fadeIn() );
			}
		}).done(function(data){
			form_status.html('<p class="text-success">Thank you for contact us. As early as possible  we will contact you</p>').delay(3000).fadeOut();
		});
	});*/

	
	
	
});

////Google Map
//function initialize_map(latitude, longitude) {
//    var myLatlng = new google.maps.LatLng(latitude,longitude);
//    var mapOptions = {
//            zoom: 14,
//            scrollwheel: false,
//            center: myLatlng
//    };
//    var map = new google.maps.Map(document.getElementById('google-map'), mapOptions);
//    var marker = new google.maps.Marker({
//            position: myLatlng,
//            map: map
////          icon: icono de iga  
//    });
//}

function initialize_map(latitude, longitude) {
    var fenway = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
    var myLatlng = new google.maps.LatLng(latitude,longitude);
    var mapOptions = {
            zoom: 16,
            scrollwheel: false,
            center: myLatlng
    };
    var map = new google.maps.Map(document.getElementById('google-map'), mapOptions);
    var marker = new google.maps.Marker({
            position: myLatlng,
            map: map
//          icon: icono de iga 
    });
    var panorama = new google.maps.StreetViewPanorama(
            document.getElementById('pano'), {
                position: fenway,
        pov: {
            heading: 34,
            pitch: 10
        }
    });
    map.setStreetView(panorama);
}


function descripcionCurso(id_curso)
{
    $('.curso').hide();
    $('.curso' + id_curso).show();
    
    var body = $("html, body");
    body.stop().animate({scrollTop:$('.curso' + id_curso).position().top - 35}, 'slow');
}

function cerrarCurso()
{
    var body = $("html, body");
    body.stop().animate({scrollTop:$('.portfolio').position().top}, '500', 'swing', function() {$('.curso').hide();});
};

function cambiarPais(cod_pais){
    $.ajax({
        type: "POST",
        url: "gestor/includes/functions.php",
        data: { "cod_pais" :  cod_pais,
            "cambiarPais" : "true" },
        success: function(data)
        {
            console.log(data);
            //location.reload(true);
            window.location.href='index.php';
            return false;
        },
        error: function(data)
        {
            console.log(data);
        }
    });
}

function cambiarIdioma(cod_idioma){
    $.ajax({
        type: "POST",
        url: "gestor/includes/functions.php",
        data: { "cod_idioma" :  cod_idioma,
            "cambiarIdioma" : "true" },
        success: function(data)
        {
            location.reload(true);
            return false;
        },
        error: function(data)
        {
            console.log(data);
        }
    });
}

function cambiarProvincia(option){
    cod_provincia = $('#provincias').val();
    $.ajax({
        type: "POST",
        url: "gestor/includes/functions.php",
        data: { "cod_provincia" :  cod_provincia,
            "cambiarProvincia" : "true" },
        dataType:'json',
        success: function(data)
        {
            $('#filiales').html("");
            $('#filiales').append(option);
        
            $.each(data, function(clave, valor)
            {
                $('#filiales').append("<option value='"+ valor.id + "'>"+ valor.nombre +"</option>");
            });
            
        },
        error: function(data)
        {
            console.log(data);
        }
    });
}

function cambiarProvinciaMatricula(option){
    cod_provincia = $('#provincias').val();
    $.ajax({
        type: "POST",
        url: "gestor/includes/functions.php",
        data: { "cod_provincia" :  cod_provincia,
            "cambiarProvincia" : "true" },
        dataType:'json',
        success: function(data)
        {
            $('#filiales_matricula').html("");
            $('#filiales_matricula').append(option);
        
            $.each(data, function(clave, valor)
            {
                $('#filiales_matricula').append("<option value='"+ valor.id + "'>"+ valor.nombre +"</option>");
            });
            
        },
        error: function(data)
        {
            console.log(data);
        }
    });
}

function filialSeleccionada()
{
    cod_filial = $('#filiales').val();
    $.ajax({
        type: "POST",
        url: "gestor/includes/functions.php",
        data: { "cod_filial" :  cod_filial,
            "filialSeleccionada" : "true" },
        dataType:'json',
        success: function(data)
        {
            $('.direccion').html(data.domicilio);
            $('.telefono').html(data.telefono);
            $('.mail').html(data.email);
            $('#correo').val(data.email);
            $('.contact-form').show('slow',function(){initialize_map(data.latitud, data.longitud);});
        },
        error: function(data)
        {
            console.log(data);
        }
    });
    //    $('.contact-form').show('slow');
}

function filialModalSeleccionada(filial, cod_curso){
    var cod_curso = cod_curso;
    var filial = filial;
    window.location = "cursos.php?cod_curso="+cod_curso+"&id_filial="+filial;
}

function filialModalSeleccionadaCC(filial){
    var filial = filial;
    window.location = "cursos_cortos.php?id_filial="+filial;
}
function scroll(to)
{
    $('.in').removeClass('in');
    $('#desplegableCursos').hide();
    var body = $("html, body");
    var top = $('#'+to).position().top;
    
    if(($('.navbar-fixed-top').length))
    {
        top -=  112;
    }
    else
    {
        top -=  228;
    }

    body.stop().animate({scrollTop:top}, '500', 'swing');
}

function iralink(url)
{
    //    console.log(url);
    window.open(url);
}

function getSelectCursos(selector, select){
    if($('#'+selector).val() == '3'){
        $('#'+select).show();
    }else{
        $('#'+select).hide();
    }
}

$('#cursos').click(function()
{
    if($('#colapseButton').css('display') == 'block')
    {
        $('.navbar-collapse').removeClass('in');
        
        var body = $("html, body");
        $('#desplegableCursos').hide();
        var top = $('#grillaCursos').position().top - 200;
        body.stop().animate({scrollTop:top}, '500', 'swing');
    }
    else
    {
        var top = $('#cursos').position().top + 52;
        var left = $('#cursos').position().left;

        $('#desplegableCursos').css({ top: top + 'px'});
        $('#desplegableCursos').css({ left: left + 'px'});

        var cursosBack = $('.main-nav').css('background-color');

        $('#desplegableCursos').css('background-color', cursosBack);
        $('#desplegableCursos').slideToggle('fast');
    }
});

$('#buscarGrilla').click(function(){
    var idioma_filtro = $('#idioma_filtro').val();
    var pais_filtro = $('#pais_filtro').val();
    var tipo_filtro = $('#tipo_filtro').val();
    var habilitado_filtro = $('#habilitado_filtro').val();
    var id_curso_filtro = $('#id_curso_filtro').val();

    var url = '../gestor/grilla_edit.php';
    url += '?idioma_filtro=' + idioma_filtro;
    url += '&pais_filtro=' + pais_filtro;
    url += '&tipo_filtro=' + tipo_filtro;
    url += '&habilitado_filtro=' + habilitado_filtro;
    url += '&id_curso_filtro=' + id_curso_filtro;
    
    window.location.replace(url);
    
});

$('.btn-submit').click(function(){
    $(this).button('loading');
    $.ajax({
        type: "POST",
        url: "gestor/controller_ajax.php",
        data: { 
            "option":"enviar_consulta",
            "filial": $('#filiales').val(),
            "nombre": $('#name').val(),
            "email": $('#email').val(),
            "phone": $('#phone').val(),
            "tipo": $('#opciones').val(),
            "message": $('#message').val(),
            "cod_curso": $('#cursos_contacto').val(),
            "g-recaptcha-response": $('#g-recaptcha-response').val()
        },
        dataType:'json',
        success: function(data)
        {
            $('.btn-submit').button('reset');
            if(data.success){
                $('#mensaje_contacto').html("<div class='text-reserva-ok'>"+data.mensaje+"</div>");
                $('#main-contact-form')[0].reset();
                $('#google_pixel').append('<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/960091823/?value=30.00&amp;currency_code=ARS&amp;label=JiQzCKXB4GMQr63nyQM&amp;guid=ON&amp;script=0"/>');
            }else{
                $('#mensaje_contacto').html("<div class='text-reserva-error'>"+data.mensaje+"</div>");  
            }
        },
        error: function(data)
        {
            $('.btn-submit').button('reset');
            $('#mensaje_contacto').html("<div class='text-reserva-error'>"+data.mensaje+"</div>");
        }
    });
});

$('.fullParaCerrarMenu').click(function(){
    $('#desplegableCursos').hide('fast');
});

$('.arrowTop').click(function(){
    $('html, body').animate({scrollTop: 0}, 500);
});

$(document).ready(function(){
    
    $('.textos_grilla').hover(
            function(){
                var id = $(this).attr('id');    
                    
        $('.imagenGrilla').hide();

        if($('#grilla-' + id).css('display') === 'none')
        {
            $('#grilla-' +id).show('fast');
        }    
    }, function(){return false});
            
    $('.textos_grilla25').hover(
            function(){
                var id = $(this).attr('id');    
                    
        $('.imagenGrilla').hide();

        if($('#grilla-' + id).css('display') === 'none')
        {
            $('#grilla-' +id).show('fast');
        }    
    }, function(){return false});
        
    $('.textos_grilla33').hover(
            function(){
                var id = $(this).attr('id');    
                    
        $('.imagenGrilla').hide();

        if($('#grilla-' + id).css('display') === 'none')
        {
            $('#grilla-' +id).show('fast');
        }    
    }, function(){return false});
        
    $('.textos_grilla50').hover(
            function(){
                var id = $(this).attr('id');    
                    
        $('.imagenGrilla').hide();

        if($('#grilla-' + id).css('display') === 'none')
        {
            $('#grilla-' +id).show('fast');
        }    
    }, function(){return false});
});
function buscarNoticias()
{
    var url = "novedades.php?buscar=1";
    var palabra = $('#palabra').val();
    var categoria = $('#categorias').val();
    var fecha = $('#fecha').val();
    
    if(palabra.length > 0)
    {
        url += '&palabra=' + palabra;
    }
    if(categoria != 0)
    {
        url += '&categoria=' + categoria;
    }
    if(fecha.length > 0)
    {
        url += '&fecha=' + fecha;
    }
    
    window.location.href = url;
}

