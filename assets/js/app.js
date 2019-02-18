/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (style.scss in this case)
require('../css/style.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// loads the jquery package from node_modules
const $ = require('jquery');

require('jquery-ui-bundle');

//var slick = require("slick-carousel");
window.jQuery = $;

require("@fancyapps/fancybox");
// create global $ and jQuery variables
global.$ = global.jQuery = $;

// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
var main = require('./main');

$(document).ready(function() {
    //Lightbox

    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });

    $(".zoom").hover(function(){
        $(this).addClass('transition');
    }, function(){
        $(this).removeClass('transition');
    });
});

