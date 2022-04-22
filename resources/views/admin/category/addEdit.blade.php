@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a  class="btn btn-primary" href="{{ route('categories.index') }}">View Category</a></li> 
              
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
                <h3 class="card-title">{{isset($category) ? 'Update # '.$category->id : 'Add New' }} </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form class="form-horizontal" id="category-add-edit" action="{{isset($category) ? route('categories.update',$category->id) : route('categories.store')}}" method="POST" enctype="multipart/form-data">
              @csrf
              {{ isset($category) ? method_field('PUT'):'' }}
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                    <input class="form-control" name="name"  placeholder="Enter your name" type="text" value="{{isset($category) ? $category->name : '' }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Restriction</label>
                    <div class="col-sm-10">
                      <select name="restriction" id="restriction" class="form-control">
                        <option value=""  >No Restriction</option>
                        <option value="adult" {{ (isset($category) && $category->restriction == 'adult') ? 'selected' : '' }}>18+ Adult</option>
                      </select>
                    </div>
                  </div>
                <div id="res">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Min Age</label>
                    <div class="col-sm-10">
                    <input type="number" name="min_age" value="{{isset($category) ? $category->min_age : '' }}" class="form-control" placeholder="please enter min age">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Max Age</label>
                    <div class="col-sm-10">
                    <input type="number" name="max_age" value="{{isset($category) ? $category->max_age : '' }}" class="form-control" placeholder="please enter max age">
                    </div>
                  </div>
                </div>
               
             
                    
                
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">{{isset($category) ? 'Update' : 'Save' }}</button>
             
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
<script> 
 
$(document).ready(function(){
  $("#res").hide();
    $('#restriction').on('change', function() {
      if ( this.value == 'adult')
      {
        $("#res").show();
      }
      else
      {
        $("#res").hide();
      }
    });
    var main_select = document.getElementById("restriction");
    var desired_box = main_select.options[main_select.selectedIndex].value;
    if(desired_box == 'adult') {
      $("#res").show();
    }

});
</script>
@if(isset($category))
{!! JsValidator::formRequest('App\Http\Requests\Admin\Category\UpdateRequest','#category-add-edit') !!}
@else
{!! JsValidator::formRequest('App\Http\Requests\Admin\Category\StoreRequest','#category-add-edit') !!}
@endif

@endsection
