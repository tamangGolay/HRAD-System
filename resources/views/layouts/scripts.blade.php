<!-- jQuery UI 1.11.4 -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="{{asset('/admin-lte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('/admin-lte/plugins/bootstrap/js/bootst
rap.bundle.min.js')}}"></script>
<script src="{{asset('/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/admin-lte/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{asset('/admin-lte/dist/js/pages/dashboard.js')}}"></script> -->
<script src="{{asset('/admin-lte/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- jquery-validation -->

<script src="{{asset('/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<!-- DataTables -->
<script src="{{URL::asset('/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<!-- <script src="{{URL::asset('/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script> -->
<!-- Script for export file from datatable -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script src="{{asset('/admin-lte/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/buttons.pdfmake.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/jszip.min.js')}}"></script>
<script src="{{asset('/admin-lte/datatables/vfs_fonts.js')}}"></script>
<!-- checkin form -->
<script>
$(function() {
	$("#example1").DataTable({
		"dom": 'Bfrtip',
		"responsive": false,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"paging": true,
		buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5'
			'pdfHtml5'
		]
	});
});
</script>