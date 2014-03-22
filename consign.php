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
			<p class="text-center text-info">You currently have no items added to the consignment form.</p>

			<table class="table table-hover table-responsive table-bordered">
				<tr>
					<th>#</th>
					<th>Course</th>
					<th>Name</th>
					<th>Price</th>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
			<button id="add_button" name="add_button" class="btn btn-primary btn-success pull-right" data-toggle="modal" data-target="#add_book_modal">Add Book</button>
			
			<!-- Modal -->
			<div class="modal fade" id="add_book_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="add_book_modal_label">Add a Book</h4>
			      </div>
			      <div class="modal-body">

			        <form role="form" class="form-horizontal">
			        	<div class="form-group">
			        		<label for="isbn">ISBN</label>
			        		<input type="text" class="input-medium" id="isbn" placeholder="Enter ISBN">
			        	</div>
			        </form>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			        <button type="button" class="btn btn-success">Add</button>
			      </div>
			    </div>
			  </div>
			</div>

		</div>
	</div>
</div>
