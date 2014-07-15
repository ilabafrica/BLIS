@section("footer")

	<!-- Delete Modal-->
	<div class="modal fade confirm-delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
			aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">
						<span class="glyphicon glyphicon-trash"></span> 
						Confirm Delete
					</h4>
				</div>
				<div class="modal-body">
					<p>Do you wish to delete this item?</p>
					<p>This action is irreversible.</p>
					<input type="hidden" id="delete-url" value="" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-delete">Delete</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>

    <footer class="footer">
        <div><a href="http://www.ilabafrica.ac.ke">iLabAfrica</a> &copy; 2014</div>
    </footer>
@show