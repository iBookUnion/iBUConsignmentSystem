$(document).ready(function(){

  $("#isbn").blur(function(){
  	var isbnInput = $(this).val()
  	var booksAPI = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbnInput + "&callback=?";
    $.getJSON(booksAPI)
    	.done(function( volumes ) {
    		if (validateFormGroups($("#isbn").parents('.form-group'))) {;
    			setRetrieved(volumes);
    		}
    	})
  });

  $("#add-book-button").click(function() {

  	var formGroupSelector = $("#add-book-modal .form-group");
  	if (validateFormGroups(formGroupSelector)) {
  		$('#add-book-modal').modal('hide');
  		addBookToConsignmentTable();
  		$('.book-form').trigger("reset");

  		// TODO: Save book data to send to server
  	} else {
  		$("#add-book-error").show();
  	}

   });
});

function setRetrieved(volumes) {
	$("#book-data-not-found").addClass('hide');

	if (!isEmpty(volumes)) {
		var volumeTitle = volumes.items[0].volumeInfo.title;
		var authors = volumes.items[0].volumeInfo.authors.join(", ");
		$("#book-data-not-found").addClass('hide');
		$("#title").val(volumeTitle);
		$("#author").val(authors);
	} else {
		$("#book-data-not-found").removeClass('hide');
	}
	$("#book-data").collapse('show');
	$("#book-add-button").removeClass('disabled');
}

function isEmpty(volumes) {
	return volumes.totalItems === 0;
}

function addBookToConsignmentTable() {
	var bookCourse = $("#course").val();
  	var bookTitle = $("#title").val();
  	var bookPrice = $("#price").val();

  	$("#no-book-info").hide();

  	$("#book-list").append("<tr><td>" + bookCourse + "</td><td>" + bookTitle + "</td><td>" + bookPrice + "</td></tr>");
}

function clearBookForm() {
	$('#book-form').reset();
}