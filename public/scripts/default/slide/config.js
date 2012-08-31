
function carrega() {
		
    setInterval(function(){
										
			   // ________________________________________________ Banima 0
				
		$(".Banima0").delay(0).animate(
            { left: "0" }, {
                duration: "normal",
                easing: "easeInQuint"
            });
				
        $(".Banima0").animate({'left' : '30px' }, 4000);
		$(".Banima0").animate({'left' : '9000px',  opacity: 0  }, 1000);
				
			   // ________________________________________________ Banima 1

		$(".Banima1").delay(6000).animate(
            { left: "0" }, {
                duration: "normal",
                easing: "easeInQuint"
            });
			
			
        $(".Banima1").animate({'left' : '30px' }, 9000);
		$(".Banima1").animate({'left' : '9000px',  opacity: 0  }, 1000);
				
	    // ________________________________________________ Banima 2

		$(".Banima2").delay(16000).animate(
            { left: "0" }, {
                duration: "normal",
                easing: "easeInQuint"
            });
		
        $(".Banima2").animate({'left' : '30px' }, 12000);
		$(".Banima2").animate({'left' : '9000px',  opacity: 0  }, 1000);
											
												
	   // ________________________________________________ anima 1
       $(".anima0").delay(29000).animate(
            { left: "0" }, {
                duration: "normal",
                easing: "easeInQuint"
            });
				
        $(".anima0").animate({'left' : '30px' }, 6000);
				$(".anima0").animate({'left' : '9000px',  opacity: 0  }, 1000);

												
		// ________________________________________________ anima 1
        $(".anima1").delay(39000).animate(
            { right: "0" }, {
                duration: "normal",
                easing: "easeInQuint"
            });
				
        $(".anima1").animate({'right' : '30px' }, 12000);
				$(".anima1").animate({'left' : '9000px',  opacity: 0  }, 1000);

				
		// ________________________________________________ anima 2
        $(".anima2").delay(52000).animate(
            { left: "0" }, {
                duration: "slow",
                easing: "easeInQuint"
            });
				
        $(".anima2").animate({'left' : '30px' }, 5000);
				$(".anima2").animate({'left' : '9000px',  opacity: 0  }, 1000);

		// ________________________________________________ anima 1
        $(".anima3").delay(58000).animate(
            { right: "0" }, {
                duration: "normal",
                easing: "easeInQuint"
            });
				
        $(".anima3").animate({'right' : '0' }, 999000);
				$(".anima1").animate({'left' : '9000px',  opacity: 0  }, 1000);
        }, 
		
		1000);

setTimeout("setTimeout('delayedRedirect()')", 39000);

function delayedRedirect(){
    //window.location = "http://www.pinhonline.com.br/portal/index.php";
}


}