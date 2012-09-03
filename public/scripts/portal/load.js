// JavaScript Document

// $('.menu').load('menu.php');

Cufon.replace('.menu', { fontFamily: 'helvetica', hover: true });
Cufon.replace('h1', { fontFamily: 'helvetica', hover: true }); 
Cufon.replace('h2', { fontFamily: 'helvetica', hover: true }); 
Cufon.replace('h3', { fontFamily: 'helvetica', hover: true }); 
Cufon.replace('h4', { fontFamily: 'helvetica', hover: true }); 
Cufon.replace('h5', { fontFamily: 'helvetica', hover: true });
Cufon.replace('h6', { fontFamily: 'helvetica', hover: true }); 
Cufon.replace('p', { fontFamily: 'helvetica', hover: true }); 
Cufon.replace('.section', { fontFamily: 'helvetica', hover: true });
Cufon.replace('button', { fontFamily: 'helvetica', hover: true });
Cufon.replace('.button', { fontFamily: 'helvetica', hover: true });



jQuery(document).ready(function(){
		jQuery("#loginForm").validationEngine();
		jQuery("#contatoForm").validationEngine();
});

$(window).load(function() { $('#preloader').delay(1000).fadeOut(400, function() {$('body').css('overflow','visible');$(this).remove();});});

$(document).ready(function(){var a=navigator.userAgent.toLowerCase();$.browser.chrome=/chrome/.test(navigator.userAgent.toLowerCase());if($.browser.msie){$('body').addClass('browserIE');$('body').addClass('browserIE'+$.browser.version.substring(0,1))}if($.browser.chrome){$('body').addClass('browserChrome');a=a.substring(a.indexOf('chrome/')+7);a=a.substring(0,1);$('body').addClass('browserChrome'+a);$.browser.safari=false}if($.browser.safari){$('body').addClass('browserSafari');a=a.substring(a.indexOf('version/')+8);a=a.substring(0,1);$('body').addClass('browserSafari'+a)}if($.browser.mozilla){if(navigator.userAgent.toLowerCase().indexOf('firefox')!=-1){$('body').addClass('browserFirefox');a=a.substring(a.indexOf('firefox/')+8);a=a.substring(0,1);$('body').addClass('browserFirefox'+a)}else{$('body').addClass('browserMozilla')}}if($.browser.opera){$('body').addClass('browserOpera')}});