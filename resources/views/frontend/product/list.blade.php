
@extends('frontend.layout.header')

@section('content')

   <!-- Default box -->
   <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
            @if($products->count())
         
              @foreach($products as $product)
         
                     
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                              <div class="card-header text-muted border-bottom-0">
                              
                              </div>
                              <div class="card-body pt-0">
                                <div class="row">
                                  <div class="col-7">
                                    <h2 class="lead"><b> {{$product->name}}</b></h2>
                                    <h3 class="lead"><b> Price: {{$product->price}}</b></h3>
                              
                                
                                  </div>
                                  <div class="col-5 text-center">
                                    <img src="{{asset('images/products/'.$product->image)}}" alt="user-avatar" class="img-circle img-fluid">
                                  </div>
                                </div>
                              </div>
                              <div class="card-footer">
                                <div class="text-right">
                                
                                  <a href="{{route('singleProduct',$product->id)}}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user"></i> View Product
                                  </a>
                                </div>
                              </div>
                            </div>
                            </div>
                @endforeach
              @else
           
              <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                              <div class="card-header text-muted border-bottom-0">
                              
                              </div>
                              <div class="card-body pt-0">
                                <div class="row">
                                  <div class="col-7">
                                    <h2 class="lead"><b> No Product Available</b></h2>
                                  
                                
                                  </div>
                                  <div class="col-5 text-center">
                                   
                                  </div>
                                </div>
                              </div>
                              <div class="card-footer">
                                <div class="text-right">
                                
                                  
                                </div>
                              </div>
                            </div>
                            </div>
            @endif
            </div>      
          </div>
        </div> 
@endsection