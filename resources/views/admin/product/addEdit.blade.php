@extends('admin.layouts.app')




@section('content')
<!-- Content Header (Page header) -->
<style>
  .bootstrap-tagsinput .tag {background: #4a93ed;border-radius: 4px;padding: 1px 5px;}
</style>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a  class="btn btn-primary" href="{{ route('products.index') }}">View Product</a></li> 
              
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
                <h3 class="card-title">{{isset($product) ? 'Update # '.$product->id : 'Add New' }} </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form class="form-horizontal" id="product-add-edit" action="{{isset($product) ? route('products.update',$product->id) : route('products.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
              {{ isset($product) ? method_field('PUT'):'' }}
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                    <input class="form-control" name="name"  placeholder="Enter your name" type="text" value="{{isset($product) ? $product->name : '' }}">
                    </div>
                  </div>
             
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tags</label>
                    <div class="col-sm-10">
                   <input type="text" name="tag" class="form-control" data-role="tagsinput" placeholder="Enter tags"value="{{isset($product) ? $product->tag : '' }}" >
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                    <select name="category_id"  class="form-control">
                        @foreach($categories as $category)
                        <option {{ (isset($product) && $product->category_id  == $category->id) ? 'selected' : '' }}  value="{{$category->id}}">  {{$category->name}}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
            
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                   <input type="number" name="price" class="form-control" placeholder="Enter your price"value="{{isset($product) ? $product->price : '' }}">
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                    <textarea name="description" class="form-control" id="description">
                    {{isset($product) ? $product->description : '' }}
                    </textarea>
                    </div>
                  </div>  
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        @if(!empty($product->image))
                        <input type="file" class="dropify" data-default-file="{{asset('images/products/'.$product->image)}}"   name="image"  id="image">

                        @else
                        <input type="file" class="dropify"  name="image"   id="image">


                        @endif
                  </div>  
                  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">{{isset($product) ? 'Update' : 'Save' }}</button>
             
                </div>
                <!-- /.card-footer -->
              </form>
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
    <!-- /.content -->
@endsection

@section('scripts')
<link rel="stylesheet" href="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<script src="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script>
      $('#description').summernote({
                toolbar: [
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['insert', ['link','image', 'doc', 'video']],
        ['misc', ['codeview']],
        ],
             height: 250
             });
</script>
@if(isset($product))
{!! JsValidator::formRequest('App\Http\Requests\Admin\Product\UpdateRequest','#product-add-edit') !!}
@else
{!! JsValidator::formRequest('App\Http\Requests\Admin\Product\StoreRequest','#product-add-edit') !!}
@endif

@endsection
