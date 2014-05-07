/*
** Developed by Raghunath J
** Version 1.0
*/
(function($){
	$.fn.dragslider = function(settings){
		var options = {
			"autoplay": false,
			"draggable":true,
			"dragbar":".drag",
			"overflow":true,
			"debug":true,
			"min":1,
			"max":10,
			"fullslide":false,
			"touchenabled":true,
			"touchminx": 20,
			"touchminy": 20,
			"touchswipe": true,
			"autocenter":true,
			"prev":".prev",
			"next":".next",
			"loadmoreoption":false,
			"smoothscroll":true,
			"loadmorejson":"data.json",
			"defaultimageload":10,
			"loadmoreimages":2
		}

		if(settings){
			$.extend(options,settings);
		}



		return this.each(function(){

			function log(message){
				if(options.debug){
					console.log(message);
				}
			}
			//log("DragSlider ver 1.0 by Raghunath J");

			var element = this;
			var imagesloaded = 0;
			var childCount = 0;
			var parentWidth = 0;
			var childWidth = 0;
			var childThatFit = Math.round(parentWidth/childWidth);
			var draggable = true;
			var tempSlide = 0;
			var lastPosition = 0;
			var childPreset = 0;

			var childTotalWidth = 0;
			var childThatFitWidth = 0;

			var current = 0;

			var steps  = 0;

			var totalSteps = 0;

			var state = "right";

			


			if(options.loadmoreoption){
				//Data found in json so do load them
				var countframes,imagelist;
				$.getJSON(options.loadmorejson,function(output){
					imagelist = jQuery.makeArray(output.data);
					countframes = imagelist.length;
					preload(imagelist,countframes);
				});

				function preload(arrayOfImages,countFrames){
					var percentageLoaded = 0;
					var thisFrame = 0;
					var cache = [];
					$(arrayOfImages).each(function(){
						$(element).append('<li class="frame'+thisFrame+'"/>');
						/*var im = $("<img>").attr("src",this).load(function() {
							percentageLoaded = percentageLoaded + 100/countFrames;
							if(Math.round(percentageLoaded) == 100){
								
							}
						});
					$(element).find("li.frame"+thisFrame).append('<img src="'+this+'" />');*/
					thisFrame++;

					if(countframes == thisFrame){
						setImages(options.defaultimageload);
						resetPlugin();
					}
				});
				}

			}else{
				resetPlugin();
			}

			function setImages(loadimageset){
				log("IMAGE LOADED: "+imagesloaded);
				log("Image to load: "+loadimageset);
				for(var i = imagesloaded;i<loadimageset;i++){
					var im = $("<img>").attr("src",imagelist[i]).load(function() {

					});
					$(element).find("li.frame"+i).append('<img style="display:none;" src="'+imagelist[i]+'" />');
					$(element).find("li.frame"+i).find("img").fadeIn();
					imagesloaded++;
				}
			}



			function resetPlugin(){
				

				//Log("RESET");
				childCount = $(element).children("li").length;
				parentWidth = $(element).width();
				childWidth = $(element).find("li").outerWidth(true);
				childThatFit = Math.round(parentWidth/childWidth);
				draggable = true;
				tempSlide = 0;
				lastPosition = 0;
				childPreset = 0;
				childTotalWidth = childCount * childWidth;
				childThatFitWidth = childThatFit * childWidth;
				$(element).css("width",childTotalWidth+"px");
				if(options.overflow){
					$(element).parent().css("overflow","hidden");
				}
				if(childCount <= childThatFit){
					draggable = false;
					hideDragBar();
				}

				if(!options.fullslide){

					totalSteps = Math.ceil(childCount/childThatFit);
					steps = totalSteps - 1;
				/*log("Total Steps: "+totalSteps);
				log("Steps: "+steps);
				log("Current Steps: "+current);*/
				options.min = current;
				options.max = childTotalWidth - childWidth;
				//log("MAX moveable: "+options.max);
				if(options.autocenter){
				    //center the parent div
				    if (childThatFit > childCount) {
				    	childPreset = childCount;
				    }
				    var max_parent_width = $(element).parent().parent().width();
				    var parent_width = $(element).parent().width();
					//var width_left = 
					var change = parent_width - (childCount * childWidth);
					//log("CHANGE: " + change);
					if (change > 0) {
						change = Math.round(change / 2);
					} else {
						change = 0;
					}
					var parentWidth = $(element).parent().css({
						"width":childThatFitWidth+"px",
						"margin-left":change+"px"
					});

				}
				/*log("CHILD COUNT: "+childCount);
				log("Parent width: "+parentWidth);
				log("Child Width: "+childWidth);
				log("Elements that fit in one slide: "+childThatFit);*/
			}
			if (options.draggable) {
				var sld = $(element).parent().find(options.dragbar).slider({
					min: options.min,
					max: options.max,
					step: 1,
					animate: true,
					slide: function (e, ui) {
						//log("MOVED to " + ui.value);
						$(element).css("margin-left", "-" + ui.value + "px");
						if(options.smoothscroll){
							var prevNextCheck = sld.slider("value");
							if (prevNextCheck > ui.value) {
				                //Going left
				                log("GOING LEFT");
				                state = "left";
				            } else {
				                //Going right
				                log("GOING RIGHT");
				                state = "right";
				            }
				        }else{
				        	var imageStepper = Math.round(ui.value/childWidth);
				        	if(imageStepper%options.loadmoreimages == 0){
				        		setImages(imageStepper+10);
				        		log("Images Load crossed: "+imageStepper);
				        	}
				        }
				    },
				    stop: function (e, ui) {
				    	if(options.smoothscroll){
				    		if (state == "left") {
				                //Going left
				                log("GOING LEFT");
				                prev();
				            } else {
				                //Going right
				                log("GOING RIGHT");
				                next();
				            }
				        }
				    }
				});
			}


			disableButtonsIfRequired();

			function disableButtonsIfRequired() {

			}


			
            //Touch code. This requires touchswipe.js

            if(options.touchenabled){
            	$(element).swipe( {
            		triggerOnTouchEnd : true,
            		swipeStatus : swipe,
            		allowPageScroll:"vertical"
            	});

            	function swipe(event,phase,direction,distance,fingers){
            		if(phase =="end"){
					//touch reached end so this is where we have to make the slider move
					if(direction == "left"){
						next();
					}else if(direction == "right"){
						prev();
					}
				}
			}




		}

		function next(){
			log("MOVE NEXT");
			log("CURRENT: "+current);
			log("STEPS: "+steps);
			if(current !=  steps){
				log("VALID NEXT");
				current++;
				var multiPly = childThatFitWidth * current;
				if (options.draggable) {
					sld.slider("value", multiPly);
				}
				$(element).stop(true,true).animate({"marginLeft":"-"+multiPly+"px"},"slow");

			}
		}

			//current = 2;

			function prev(){
				log("MOVE PREV");
				log("CURRENT: "+current);
				log("STEPS: "+steps);
				if(current != 0){
					log("VALID PREV");
					current--;
					//current = current;
					var multiPly = childThatFitWidth * current;
					if (options.draggable) {
						sld.slider("value", multiPly);
					}
					$(element).animate({"margin-left":"-"+multiPly+"px"},"slow");
					
				}
			}

			function identifyStep(){

			}

			function hideDragBar(){
				$(element).parent().find(options.dragbar).hide();
			}

		    //$()

		    $(this).parent().find(options.next).click(function (e) {
		    	e.preventDefault();
		    	next();
		    });

		    $(this).parent().find(options.prev).click(function (e) {
		    	e.preventDefault();
		    	prev();
		    });

		}


	});

};
})(jQuery);