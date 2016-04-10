$(document).ready(function(){
	$(".left-sidebar ul li").hover(function(){
		$(this).children("a.category-tree").css("text-decoration", "underline");
		$(this).children("a.category-tree").css("color","#fff");
	}, function(){
		$(this).children("a.category-tree").css("text-decoration", "none");
		$(this).children("a.category-tree").css("color","#000");
	});

	var screenHeight = window.innerHeight - 30;

	var ratio = $("#product-image img").width() * 1.0 / $("#product-image img").height();

	$("#product-thumbnail img").css("height",screenHeight);

	$("#product-thumbnail img").css("width",
		$("#product-thumbnail img").css("height") * ratio);

	var left = 0;
	var top = 0;

	
	if (window.innerHeight > $("#product-thumbnail img").height()){
		top = (window.innerHeight - $("#product-thumbnail img").height())/2;
		left = (window.innerWidth - $("#product-image img").width())/2;
	}

	$("#product-thumbnail img").css("margin-top", top);
	$("#product-thumbnail").css("top", 0);
	$("#product-thumbnail").css("left", 0);

	$("#product-image").on("click", function(){
		document.getElementById('product-thumbnail').style.display = "block";
	});

	$("#product-thumbnail").on("click", function(){
		document.getElementById('product-thumbnail').style.display = "none";
	}).on("click", "img", function(e){
		e.stopPropagation();
	});


	/*
	 * scroll the homepage banner
	 */
	var currentBanner;

	$("#right-arrow").click(function(){
		currentBanner = $(".banner-scroll img.active");
		if (currentBanner.next().length > 0){
			currentBanner.removeClass("active");
			currentBanner = currentBanner.next();
			currentBanner.addClass("active");
			if (0 == currentBanner.next().length){
				$(this).addClass("inactive");
			}
			$("#left-arrow").removeClass("inactive");
		}
	});

	$("#left-arrow").click(function(){
		currentBanner = $(".banner-scroll img.active");
		if (currentBanner.prev().length > 0){
			currentBanner.removeClass("active");
			currentBanner = currentBanner.prev();
			currentBanner.addClass("active");
			if (0 == currentBanner.prev().length){
				$(this).addClass("inactive");
			}
			$("#right-arrow").removeClass("inactive");
		}
	});

	$(".banner-scroll > img:gt(0)").hide();

	setInterval(function(){
		$(".banner-scroll > img:first")
			.fadeOut(800)
			.next()
			.fadeIn(800)
			.end()
			.appendTo(".banner-scroll");
	}, 3000);


	/*
	 * image gallery
	 */
	$(".gallery-image:first").addClass("selected");

	$(".gallery-image").hover(function(){
		$(this).siblings().removeClass("selected");
		$(this).addClass("selected");
		$("#product-image img").attr("src",$(this).children("img").attr("src"));
		$("#product-thumbnail img").attr("src",$(this).children("img").attr("src"));
	});

	
	/*
	 * scale images on homepage automatically
	 */
	var cardWidth;
	var cardHeight;
	$(".product-card").each(function(){
		cardWidth = $(this).css("width")-10;
		cardHeight = $(this).css("height")-83;
		if ($(this).find("img").height() * (cardWidth / $(this).find("img").width()) > cardHeight){
			$(this).find("img").css("max-height", cardHeight);
			$(this).find("img").css("max-width", ((cardHeight/$(this).find("img").height())*$(this).find("img").width()));
		} else {
			$(this).find("img").css("max-width", cardWidth);
			$(this).find("img").css("max-height", ((cardWidth/$(this).find("img").width())*$(this).find("img").height()));
		}
	});
});