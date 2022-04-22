@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><a class="btn btn-primary" href="{{ route('products.create') }}" >Add Product</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Listing</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
                <table id="datatable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Category</th>          

                    <th>Description</th>          

                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {

       Table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: "{{ route('products.index') }}",
                    },
            columns: [
            {data: 'name', name: 'name'}, 
            {data: 'category.name', name: 'category.name'},  
            {data: 'description', name: 'description'},  
             


            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
       
    });
    
</script>
@endsection