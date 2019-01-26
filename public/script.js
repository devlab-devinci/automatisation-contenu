$(document).ready(function(){
    $('.matchsItem__header').click(function(){
       $(this).toggleClass('matchsItem__header--opened');
    });
     var img = $('#backgroundImg').attr('data-img');
    console.log(img);
    $('#backgroundImg').css('background-image', 'url("'+ img +'")');
});
