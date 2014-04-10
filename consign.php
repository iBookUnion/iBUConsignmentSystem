<div id="#consign" class="row">

	<div class="col-md-4">
		<div class="starter-template">
			<h1>Consignment</h1>
			<span class="glyphicon glyphicon-book yellow hidden-xs"></span>
			<p class="lead">Tell us about the books you'll consign with us.</p>
		</div>
	</div>

	<div class="col-md-8">

		<div class="starter-template">
			<p class="text-center text-info" id="no-book-info">You currently have no items added to the consignment form.</p>

			<table class="table table-responsive table-bordered table-hover">
				<thead>
					<tr>
						<th>Course</th>
						<th>Name</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody id="book-list">
				</tbody>
			</table>
			<button id="add_button" name="add_button" class="btn btn-primary btn-success pull-right" data-toggle="modal" data-target="#add-book-modal">Add Book</button>
		</div>
	</div>
</div>


<!-- Book Modal -->
<div class="modal fade" id="add-book-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="add_book_modal_label">Add a Book</h4>
      </div>
      <div class="modal-body">

      	<!-- Error Message Box -->
      	<div class="alert alert-danger" id="add-book-error" hidden="hidden">
      	  <a class="alert-link">Something is wrong!</a>
      	</div>

      	<!-- Book Form -->
        <form role="form" class="form-horizontal book-form">
          <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" class="form-control input-medium" id="isbn" placeholder="Enter ISBN" ibu-validate="isbn">
          </div>

          <div class="row">

          	  <div class="col-md-5">
		          <div class="form-group">
		            <label for="course">Course Number</label>
		            <input type="text" class="form-control input-medium" id="course" placeholder="Enter Course Number" ibu-validate="text">
		          </div>
	          </div>

	          <div class="col-md-1">
	          </div>

	          <div class="col-md-6">
		          <div class="form-group">
		            <label for="price">Price</label>
		            <div class="input-group">
		            	<span class="input-group-addon">$</span>
		            	<input type="number" class="form-control input-medium" id="price" placeholder="Enter Price" ibu-validate="number">
		            	<span class="input-group-addon">.00</span>
		            </div>
		          </div>
		      </div>

          </div>

          <div id="book-data" class="collapse">
          	  <hr>
	          <!-- Warning Message Box -->
	          <div class="alert alert-warning hide" id="book-data-not-found">
	            <a class="alert-link">We don't recognize the book!</a>
	          </div>

	          <div class="form-group">
	            <label for="title">Book Title</label>
	            <input type="text" class="form-control input-medium" id="title" placeholder="Enter Book Title" ibu-validate="text">
	          </div>

	          <div class="form-group">
	            <label for="author">Book Author</label>
	            <input type="text" class="form-control input-medium" id="author" placeholder="Enter Book Author" ibu-validate="text">
	          </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel-button">Cancel</button>
        <button type="button" class="btn btn-success" id="add-book-button">Add</button>
      </div>
    </div>
  </div>
</div>