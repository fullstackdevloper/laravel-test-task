
@extends('frontend.layout.header')

@section('content')
<section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
              <div class="col-12">
                <img src="{{asset('images/products/'.$product->image)}}" class="product-image" alt="Product Image">
              </div>
         
            </div>
          
              

              <div class="bg-gray py-2 px-3 mt-4">
              <h2 class="mb-0">
               {{$product->name}}
                </h2>
                <h2 class="mb-0">
                Price: ₹{{$product->price}}
                </h2>
             
              </div>

             

          

            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
               
              
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"> {{strip_tags($product->description)}}</div>
             
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>

@endsection