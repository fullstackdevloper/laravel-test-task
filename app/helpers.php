<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
if(!function_exists('category')){
  function category (){
    $category=Category::where('restriction','=' , null)->get();
   
    return $category;
  }
}
if(!function_exists('categoryResistriction')){
  function categoryResistriction (){
    $categoryResistriction= Category::where('restriction','!=' , null)->get();
    return $categoryResistriction;
  }
}