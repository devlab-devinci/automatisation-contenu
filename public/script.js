$(document).ready(function(){
    $('.matchsItem__header').click(function(){
       $(this).next('.matchsItem__content').toggle();
    });
});