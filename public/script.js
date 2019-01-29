$(document).ready(function(){
    $('.matchsItem__header').click(function(){
       $(this).toggleClass('matchsItem__header--opened');
    });


    // Création du Visuel

    var img = $('#backgroundImg').attr('data-img');
    $('#backgroundImg').css('background-image', 'url("'+ img +'")');

    // Add text on img
    $('#text-visual').on('keyup', function(){
    	var text = $(this).val();
    	$('#imageContainer p').html(text);
    });

    $('#bigger').on('click', function(){
      var fontSize = parseInt($('#imageContainer p').css("font-size"));
      fontSize = fontSize + 1 + "px";
      $('#imageContainer p').css('font-size', ''+ fontSize +'');
    });

    $('#smaller').on('click', function(){
      var fontSize = parseInt($('#imageContainer p').css("font-size"));
      fontSize = fontSize - 1 + "px";
      $('#imageContainer p').css('font-size', ''+ fontSize +'');
    });

    function heightText(){
      var height = $("#heightText").val();

      $("#imageContainer p").css("top", ''+ height +'%');

    }
    $("#heightText").change(heightText).mousemove(heightText);

    function widthText(){
      var width = $("#widthText").val();

      $("#imageContainer p").css("left", ''+ width +'%');

    }
    $("#widthText").change(widthText).mousemove(widthText);

    // editing image via css properties
    function editImage() {
    	var gs = $("#gs").val(); // grayscale
    	var blur = $("#blur").val(); // blur
    	var br = $("#br").val(); // brightness
    	var ct = $("#ct").val(); // contrast
    	var huer = $("#huer").val(); //hue-rotate
    	var opacity = $("#opacity").val(); //opacity
    	var invert = $("#invert").val(); //invert
    	var saturate = $("#saturate").val(); //saturate
    	var sepia = $("#sepia").val(); //sepia

    	$("#imageContainer img").css("filter", 'grayscale(' + gs+
    													 '%) blur(' + blur +
    													 'px) brightness(' + br +
    													 '%) contrast(' + ct +
    													 '%) hue-rotate(' + huer +
    													 'deg) opacity(' + opacity +
    													 '%) invert(' + invert +
    													 '%) saturate(' + saturate +
    													 '%) sepia(' + sepia + '%)');

    	$("#imageContainer img").css("-webkit-filter", 'grayscale(' + gs+
    													 '%) blur(' + blur +
    													 'px) brightness(' + br +
    													 '%) contrast(' + ct +
    													 '%) hue-rotate(' + huer +
    													 'deg) opacity(' + opacity +
    													 '%) invert(' + invert +
    													 '%) saturate(' + saturate +
    													 '%) sepia(' + sepia + '%)');

    }

    //When sliders change image will be updated via editImage() function
    $(".editImage").change(editImage).mousemove(editImage);

    // Reset sliders back to their original values on press of 'reset'
    $('#imageEditor').on('reset', function () {
    	setTimeout(function() {
    		editImage();
    	},0);
    });

    // Fin Création du Visuel


    // Enregistrer le visuel et envoie sur FB
    var element = $('#imageContainer')[0];
	  var getCanvas; // global variable


    $('#button-publish').on('click', function( event ) {
        event.preventDefault();

        var $imgData;

        html2canvas(element, {
         // canvas: canvas,
         allowTaint: true,
         scale: 2,
         onrendered: function (canvas) {
            getCanvas = canvas;
            imgData = canvas.toDataURL('image/jpeg');
            $.ajax({
                url: "/saveVisual",
                data: { img: imgData},
                dataType: 'json',
                type:'POST'
            })
            .done(function( response ) {
              console.log("c'est fait");
            });
         }
         });

    });

});
