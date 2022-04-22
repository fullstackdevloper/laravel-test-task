
        <!-- nav bar start  -->
@php
$category =category();
$categoryResistriction =categoryResistriction();
@endphp

     
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <a class="navbar-brand" href="{{url('shop')}}">Category</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
               
                    @foreach($category as $menu)
                    <li class="nav-item active">
                    <a class="nav-link" href="{{route('category',$menu->id)}}">{{$menu->name}}</a>
                    </li>
                    @endforeach
                    @foreach($categoryResistriction as $menu)
                    @if((isset(auth()->user()->age)) && (auth()->user()->age >= $menu->min_age) || (Auth::user()->hasRole('Admin')) )
                    <li class="nav-item active">
                      <a class="nav-link" href="{{route('category',$menu->id)}}">{{$menu->name}}</a>
                    </li>
                    @endif
                    @endforeach
                
                </ul>
                <div class="nav-item d-none d-sm-inline-block" >
                <a href="{{url('logout')}}" class="nav-link">Logout</a>
              </div>
              </div>
            </nav>
          
          <!-- navbar end  -->