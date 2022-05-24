@extends('layouts.main')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product Category Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                    <li class="breadcrumb-item active">Data Product Category</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Master Data Product Category</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table" id="tbdata">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Product Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->
<div class="modal fade" id="modal_data">
    <div class="modal-dialog" role="document">
        <form id="form_data" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="hidden" name="id">
                        <input type="text" name="name" id="name" class="form-control form-control-sm"
                            minlength="3" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('after-scripts')
<script>
    $(document).ready(function(){
        var table = $('#tbdata').DataTable({
            ajax: {
                url: "{{ route('product_category.data') }}",
                complete : function(result){
                    if(result['responseJSON']['code'] == 401){
                        Swal.fire   ({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Session expired, please login again',
                        });
                    }
                }
            },
            processing: true,
            language: {
                "loadingRecords": "&nbsp;",
                "processing": "Loading..."
            },
            order: [],
            columns: [{
                    data: 'id',
                    className: 'no-export'
                },
                {
                    data: 'name'
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        var btn_edit =
                            '<button class="btn btn-warning btn-sm btn-edit mr-2"><i class="fa fa-edit"></i> Edit</button>';
                        var btn_delete =
                            '<button class="btn btn-danger btn-sm btn-delete mr-2"><i class="fa fa-edit"></i> Delete</button>';
                        return btn_edit + btn_delete;
                    },
                    width: '201px',
                    className: 'no-export'
                },
            ],
            dom: 'Bfrtip',
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [
                'pageLength',
                {
                    extend: 'copy',
                    text: 'Copy',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    text: 'Refresh',
                    action: function(e, dt, node, config) {
                        table.ajax.reload(null, false);
                    }
                },
                {
                    text: 'Add Product Category',
                    action: function(e, dt, node, config) {
                        $('#modal_data .modal-title').html('Add Product Category');
                        //empty data
                        $('#modal_data [name=id]').val('');
                        $('#modal_data [name=name]').val('');
                        //show modal
                        $('#modal_data').modal();
                    }
                },
            ],
        });

        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        $('#form_data').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('product_category.save') }}",
                        type: "POST",
                        data: $('#form_data').serialize(),
                        success: function(response) {
                            if (response.code == 201) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                });
                                $('#modal_data').modal('hide');
                                table.ajax.reload(null, false);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message
                                });
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        }
                    });
                }
            });
        });

        $('#tbdata tbody').on('click', '.btn-edit', function() {
            $('#modal_data .modal-title').html('Edit Product Category');
            var data = table.row($(this).parent().parent()).data();
            //fill data
            $('#modal_data [name=id]').val(data['id']);
            $('#modal_data [name=name]').val(data['name']);
            //show modal
            $('#modal_data').modal();
        });

        $('#tbdata tbody').on('click', '.btn-delete', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var data = table.row($(this).parent().parent()).data();
                    $.ajax({
                        url: '{{ route("product_category.delete") }}',
                        type: 'POST',
                        data: {
                            id: data['id'],
                            _token : token,
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Please Wait',
                                text: 'Deleting data',
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                        },
                        success: function(result) {
                            Swal.close();
                            if(result.code == 201){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: result.message
                                }).then (function(){
                                    table.ajax.reload(null, false);
                                });
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: result.message,
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
