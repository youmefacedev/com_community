// binds support buttons
var documentCount = 0;
var prevId = "";

function closeSupport(id, liked) {
	jomsQuery("#like_id" + id).popover('hide');

	if (liked) {
		jomsQuery("#like_id" + id).hide();
	}
	reload();
}

function reload() {
	functionCount = 0;
}

function showLikeSupport(id) {
	jomsQuery("#like_id" + id).show();
}

// show support 
function showSupport(data, likedItem) {
	var content = "";
	var idx = 0;

	for ( var i = 0; i < data.length; i++) {
		idx++;

		if (idx == 1) {
			content += "<div class='tableRow'>";
		}

		content += "<div class='tableColumn'>";
		content += "<div class='cIndex-Box clearfix'>";

		content += "<div class='support-Content'>";
		content += "<h3 class='cIndex-Name cResetH'>";
		content +=  data[i].description;
		content += "</h3>";

		content += "<div class='cIndex-Status' style='text-align:center'><span><img src='../../.."
				+ data[i].imageURL + "'/></span></div>";
		content += "<div class='cIndex-Status'><span></span><span>"
				+ data[i].valuePoint + " pts</span></div>";
		content += "<div class='cIndex-Actions'><a href='#' class='btn btn-primary' id=sendSupport"
				+ data[i].id
				+ " giftId="
				+ data[i].id
				+ " itemId="
				+ likedItem
				+ ">Send</a></div>";

		content += "</div>";
		content += "</div>";
		content += "</div>";

		if (idx == 5 || (i + 1) == data.length) {
			content += "</div>"; // ending tag 
		}

		if (idx == 5) {
			idx = 0;
		}
	}

	closeOtherPopup("#like_id" + likedItem);

	jomsQuery("#like_id" + likedItem)
			.popover(
					{
						placement : 'right',
						title : 'Like '
								+ '<button type="button" id="close" class="close" onclick="jomsQuery(&quot;#like_id'
								+ likedItem
								+ '&quot;).popover(&quot;hide&quot;);">&times;</button>',
						content : content

					}).popover('show');

	prevId = "#like_id" + likedItem;

}

function closeOtherPopup(currentId) {
	if (prevId == "")
		return;

	if (prevId == currentId)
		return;

	jomsQuery(prevId).popover('hide');

}
