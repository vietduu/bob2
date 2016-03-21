$(document).ready(function(){
	$("#navigation .item").each(function(){
		$(this).hover(function(){
			$(this).children(".sub-menu").css("display", "block");
		}, function(){
			$(this).children(".sub-menu").css("display", "none");
		});
	});

	$("select[name='fk_cms_item_type']").on('change',function(){
		var name = $(this).find("option:selected").text();
		var selectedIdx = parseInt($(this).find("option:selected").val());
		switch(selectedIdx){
			case 0:
			case 4:
			case 9:
			case 13:
			case 15:
			case 17:
			case 18:
			case 19:
			case 21:
			case 27:
				$(this).find("option:selected").addClass("off");
				$("#cms-detail-page .ui-summary").append(createTextbox(selectedIdx, name));
				break;
			case 2:
			case 3:
			case 5:
			case 6:
			case 7:
			case 8:
			case 10:
			case 12:
			case 14:
			case 20:
			case 24:
			case 25:
				$(this).find("option:selected").addClass("off");
				$("#cms-detail-page .ui-summary").append(createTextarea(selectedIdx, name));
				break;
			case 11:
			case 16:
				$(this).find("option:selected").addClass("off");
				$("#cms-detail-page .ui-summary").append(createCheckbox(selectedIdx, name));
				break;
			case 1:
			case 22:
			case 23:
			case 26:
			case 28:
			case 29:
				$(this).find("option:selected").addClass("off");
				$("#cms-detail-page .ui-summary").append(createTextarea(selectedIdx, name, "10"));
				break;
			default:
		}
	});

	$("#cms-detail-page .ui-formRow:not(.ui-summary,.ui-submit-field)").each(function(i,e){
		$("select[name='fk_cms_item_type']").children().each(function(){
			if ($(e).attr("data-id") == $(this).attr("value")){
				$(this).addClass("off");
			}
		});
	});

	var array = [];
	$("#cms-detail-page #submit_btn").click(function(e){
		$("#cms-detail-page").load();
		e.preventDefault();
		var href = window.location.href;
		var generalFolder = href.substr(href.lastIndexOf('/')+1);
		if ($("#cms-detail-page .ui-formRow:not(.ui-summary,.ui-submit-field)").length == 0){
			$("#cms-detail-page").append("<span id='notification'>*Please select at least one item</span>");
		} else {
		$("#cms-detail-page .ui-formRow:not(.ui-summary,.ui-submit-field)").each(function(){
			var fk_cms_folder = generalFolder;
			var id_cms_item = "";
			var fk_cms_item_type = $(this).attr("data-id");
			var content = $(this).children(".ui-formCol2").children().val();
			if ($(this).children("input").length != 0){
				id_cms_item = $(this).children("input").val();
			}

			if (fk_cms_folder == '' || fk_cms_item_type == '' || content == ''){
				alert("Please fill the text...");
			}
			if (fk_cms_item_type == "11" || fk_cms_item_type == "16"){
				if ($(this).children(".ui-formCol2").children().prop("checked")){
					content = "checked";
				} else {
					content = "";
				}
			}
			var row = 'id_cms_item=' + id_cms_item +'&fk_cms_folder=' + fk_cms_folder + '&fk_cms_item_type=' + fk_cms_item_type + '&content=' + content;
			array.push(row);
		});

		var arrayString = array[0];
		for (var i=1; i<array.length; i++){
			arrayString = arrayString + ',' + array[i];
		}

		$.ajax({
			type: "POST",
			url: window.location.href,
			data: ({array:arrayString}),
			cache: false,
			success: function(data){
				array = [];
				var url = window.location.href;
				window.location=url.substring(url.lastIndexOf("/edit"), 0);
			}
		});
	}
	});

	$("#cancel_btn").click(function(e){
		e.preventDefault();
		var url = window.location.href;
		window.location=url.substring(url.lastIndexOf("/delete"), 0);
	});
});


function createTextbox(id, name) {
	var data = 	"<div class='ui-formRow' data-id=" + id + ">"
			+		"<div class='ui-formCol1'>"
			+			"<label>" + name + " </label>"
			+		"</div>"
			+		"<div class='ui-formCol2'>"
			+			"<input type='text' name='" + name + "'></input>"
			+		"</div>"
			+		"<div class='ui-formCol3'>"
			+ 			"<a class='remove' onClick='removeField(this,"+ id + ")'><img src='/alice2/public/img/icon/circle-delete.png')' alt='delete' /></a>"
			+		"</div>"
			+	"</div>";

	return data;
}

function createTextarea(id, name, rows="4") {
	var data = 	"<div class='ui-formRow' data-id=" + id + ">"
			+		"<div class='ui-formCol1'>"
			+			"<label>" + name + " </label>"
			+		"</div>"
			+		"<div class='ui-formCol2'>"
			+			"<textarea rows='" + rows + "'></textarea>"
			+		"</div>"
			+		"<div class='ui-formCol3'>"
			+ 			"<a class='remove' onClick='removeField(this,"+ id + ")'><img src='/alice2/public/img/icon/circle-delete.png')' alt='delete' /></a>"
			+		"</div>"
			+	"</div>";

	return data;
}

function createCheckbox(id, name) {
	var data = 	"<div class='ui-formRow' data-id=" + id + ">"
			+		"<div class='ui-formCol1'>"
			+			"<label>" + name + " </label>"
			+		"</div>"
			+		"<div class='ui-formCol2'>"
			+			"<input type='checkbox' name='"+name+"'>"
			+		"</div>"
			+		"<div class='ui-formCol3'>"
			+ 			"<a class='remove' onClick='removeField(this,"+ id + ")'><img src='/alice2/public/img/icon/circle-delete.png')' alt='delete' /></a>"
			+		"</div>"
			+	"</div>";

	return data;
}

function removeField(element, id) {
	$("select[name='fk_cms_item_type']").find("option[value="+id+"]").removeClass("off");
	$(element).parent().parent().remove();
}