jQuery(document).ready(function($){$('#nav-wrap').prepend('<div id="menu-icon">Menu</div>');$("#menu-icon").on("click",function(){$("#nav").slideToggle();$(this).toggleClass("active");});});jQuery(document).ready(function($){$(window).stellar();var links=$('.navigation').find('li');slide=$('.slide');button=$('.button');mywindow=$(window);htmlbody=$('html,body');function goToByScroll(dataslide){htmlbody.animate({scrollTop:$('.slide[data-slide="'+dataslide+'"]').offset().top-60},1000,'easeInOutQuint');}
links.click(function(e){e.preventDefault();dataslide=$(this).attr('data-slide');goToByScroll(dataslide);});button.click(function(e){e.preventDefault();dataslide=$(this).attr('data-slide');goToByScroll(dataslide);});$(document).ready(function(){$('.bxslider').bxSlider({adaptiveHeight:true,speed:900,touchEnabled:false});});$("a.prettyPhoto").prettyPhoto({social_tools:'',deeplinking:false,theme:'light_square'});jQuery("a[data-rel^='prettyPhoto']").prettyPhoto();$('.tip[title]').qtip({position:{my:'bottom center',at:'top center',adjust:{x:-1,y:-32}},style:{classes:'ui-tooltip-tipsy ui-tooltip-shadow'}});$(function(){$(".photos img").hover(function(){$(this).stop().animate({opacity:.7},"slow");},function(){$(this).stop().animate({opacity:1},"slow");});});});