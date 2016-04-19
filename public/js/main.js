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
	$("#left-arrow, #right-arrow").css("top", $(".homepage-banner").height() / 2 - 20);


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
	}, 5000);


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


	var cardTotalWidth = $(".product-card").length * $(".product-card").outerWidth(true);

	$(".product-list").width(cardTotalWidth);
	console.log(cardTotalWidth);

	var scroller = $(".product-list");
	$("#flex-right-navigator").click(function(){
		if (Math.abs(scroller.position().left) + $(".product-placeholder-content").outerWidth() < cardTotalWidth){
			scroller.animate({left: '-=' + $(".product-placeholder-content").outerWidth()}, 1000, function(){
				console.log(scroller.position().left);
			});
		} else {
			scroller.css('left','0px');
		}		
	});

	$("#flex-left-navigator").click(function(){
		if (Math.abs(scroller.position().left) - $(".product-placeholder-content").outerWidth() >= 0){
			scroller.animate({left: '+=' + $(".product-placeholder-content").outerWidth()}, 1000, function(){
				console.log(scroller.position().left);
			});
		} else {
			scroller.css('left','0px');
		}
	});

	addBorderOutline($(".product-card"));
	addBorderOutline($(".detail-list__product-card"));

	$(".homepage-banner #right-arrow").css("left", $(".container").width() 
		- $(".homepage-banner #right-arrow").width() - 10);

	// news
	var pageCounter = $(".news-list > li").length;
	var pageOffset = 10;
	for (var i=1; i <= Math.ceil(pageCounter*1.0/pageOffset);i++){
		$(".paging").append("<div class='page" + i + "'><a>" + i + "</a></div>");
	}


	$(".paging > div").each(function(){
		$(this).click(function(){
			$(".news-list > li").css("display", "none");
			$(".paging a").removeClass("active-page");
			$pageNumber = parseInt($(this).children("a").text());
			$("#current-page").text($pageNumber);
			$startNumber = ($pageNumber-1)*pageOffset+1;
			$endNumber = $pageNumber * pageOffset;
			for (var i = $startNumber; i <= $endNumber; i++){
				$(".news-list > li:nth-child(" + i + ")").css("display", "block");				
			}
			$(this).children("a").addClass("active-page");
		});
	});

	$(".paging > div:nth-child(1)").click();

	$(".prev-pager-navigator").click(function(){
		$curPage = parseInt($("#current-page").text());
		if (1 < $curPage){
			$(".paging > div:nth-child(" + ($curPage-1) + ")").click();
		}
	});

	$(".next-pager-navigator").click(function(){
		$curPage = parseInt($("#current-page").text());
		if ($(".paging > div").length > $curPage){
			$(".paging > div:nth-child(" + ($curPage+1) + ")").click();
		}
	});

	$(".start-pager-navigator").click(function(){
		$(".paging > div:nth-child(1)").click();
	});

	$(".end-pager-navigator").click(function(){
		$(".paging > div:nth-child(" + $(".paging > div").length + ")").click();
	});
});

function addBorderOutline(element){
	$(element).each(function(){
		$(this).hover(function(){
			$(this).addClass("border-outline");
		}, function(){
			$(this).removeClass("border-outline");
		});
	});
}