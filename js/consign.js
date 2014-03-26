$(document).ready(function(){
alert("Javascript is alert ;)")
  $("#isbn").blur(function(){
  	var isbnInput = $(this).val()
  	var booksAPI = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbnInput + "&callback=?";
    $.getJSON(booksAPI)
    	.done(function( volumes ) {
    		setRetrieved(volumes);
    	})
  });

  $("#add-button").click(function() {
  	var bookCourse = $("#course").val();
  	var bookTitle = $("#title").val();
  	var bookPrice = $("#price").val();

  	$("#no-book-info").hide();

  	$("#book-list").append("<tr><td>" + bookCourse + "</td><td>" + bookTitle + "</td><td>" + bookPrice + "</td></tr>");
  });
});

function setRetrieved(volumes) {
	if (!isEmpty(volumes)) {
		var volumeTitle = volumes.items[0].volumeInfo.title;
		var authors = volumes.items[0].volumeInfo.authors.join(", ");
		$("#title").val(volumeTitle);
		$("#author").val(authors);
	}
}

function isEmpty(volumes) {
	return volumes.totalItems === 0;
}



// https://www.googleapis.com/books/v1/volumes?q=isbn
