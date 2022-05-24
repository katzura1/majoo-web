@extends('layouts.main')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                    <li class="breadcrumb-item active">Data Product</li>
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
            <h3 class="card-title">Master Data Product</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table" id="tbdata">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name Product</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Nama Category</th>
                                <th>Image</th>
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
    <div class="modal-dialog modal-lg" role="document">
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
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description" class="form-control form-control-sm"
                            minlength="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" id="price" class="form-control form-control-sm maskMoney"
                            minlength="3" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="id_product_category" id="id_product_category" class="form-control form-control-sm" required>
                        </select>
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

<div class="modal fade" id="modal_photo">
    <div class="modal-dialog" role="document">
        <form id="form_photo" method="POST" enctype="multipart/form-data">
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
                        <label>Photo</label>
                        <input type="hidden" name="id">
                        <input type="file" name="photo" id="photo" class="form-control form-control-sm" required>
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
            $('#description').summernote();

            var table = $('#tbdata').DataTable({
                ajax: {
                    url: "{{ route('product.data') }}",
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
                        data: 'description',
                        render : function(data, type, row){
                            return stripHtml(data).substring(0,150)+'....';
                        },
                        width: '20%',
                    },
                    {
                        data: 'price',
                        render : function(data, type, row){
                            return 'Rp. '+formatRupiah(data);
                        }
                    },
                    {
                        data : 'product_category',
                        render : function(data, type, row){
                            return data.name;
                        }
                    },
                    {
                        data : 'image',
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            var btn_edit = '<button class="btn btn-warning btn-sm btn-edit mr-2"><i class="fa fa-edit"></i> Edit</button>';
                            var btn_delete = '<button class="btn btn-danger btn-sm btn-delete mr-2"><i class="fa fa-edit"></i> Delete</button>';
                            var btn_photo = '<button class="btn btn-info btn-sm btn-photo mr-2"><i class="fa fa-photo"></i> Photo</button>';
                            return btn_edit + btn_delete + btn_photo;
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
                        text: 'Add Product',
                        action: function(e, dt, node, config) {
                            $('#modal_data .modal-title').html('Add Product');
                            //empty data
                            $('#modal_data [name=id]').val('');
                            $('#modal_data [name=name]').val('');
                            $('#modal_data [name=description]').val('');
                            $('#modal_data [name=price]').val('');
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

            $("select[name='id_product_category']").select2({
                ajax: {
                    url: "{{ route('product_category.select2') }}",
                    type: "POST",
                    dataType: 'JSON',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term, // search term
                            _token: token,
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
                placeholder: 'Select Product Category',
                allowClear: true,
            });

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
                            url: "{{ route('product.save') }}",
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
                $('#modal_data [name=description]').summernote('code',data['description']);
                $('#modal_data [name=price]').val(formatRupiah(data['price']));
                var option = new Option(data['product_category']['name'], data['product_category']['id'], true, true);
                $('#modal_data [name=id_product_category]').append(option).trigger('change');
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
                            url: '{{ route("product.delete") }}',
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

            $('#tbdata tbody').on('click', '.btn-photo', function(){
                var data = table.row($(this).parent().parent()).data();
                $('#modal_photo .modal-title').html('Product Photo');
                $('#modal_photo [name=id]').val(data['id']);
                $('#modal_photo').modal();
            });

            $('#form_photo').on('submit', function(e){
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
                            url: "{{ route('product.save_photo') }}",
                            type: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Please Wait',
                                    text: 'Saving data',
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
                                        $('#modal_photo').modal('hide');
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
            })
        })
    </script>
@endpush
