@extends('layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard Page</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('')}}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard Page</li>
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
                <h3 class="card-title">Product List</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($products as $item)
                        <div class="col-sm-4">
                            <div class="position-relative p-3 bg-white border" style="height: 180px">
                                <div class="ribbon-wrapper ribbon-xl">
                                    <div class="ribbon bg-secondary">
                                    {{ $item['product_category']['name'] }}
                                    </div>
                                </div>
                                    {{ $item['name'] }} <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small>.
                                            {{ substr(strip_tags($item['description']), 0, 150).'...' }}
                                        </small>
                                        <br><br>
                                        <b>{{ 'Rp.'.number_format($item['price']) }}</b>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ env('API_URL_PUBLIC').$item['image'] }}" style="height: 120px; width:150px" alt="Product Photo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
@endsection
