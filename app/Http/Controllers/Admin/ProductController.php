<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use DataTables;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $data = Product::with('category')->get();

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function ($row)
                            {
                                $action = '
                        <a  href="' . route("products.edit", $row) . '" class="btn btn-sm btn-info btn-b"><i class="las la-pen"></i>
                       Edit
                        </a>

                        <a href="' . route("products.destroy", $row) . '"
                                class="btn btn-sm btn-danger remove_us"
                                title="Delete User"
                                data-toggle="tooltip"
                                data-placement="top"
                                data-method="DELETE"
                                data-confirm-title="Please Confirm"
                                data-confirm-text="Are you sure that you want to delete this User?"
                                data-confirm-delete="Yes, delete it!">
                                Delete
                                <i class="las la-trash"></i>
                            </a>
                    ';
                                return $action;
                            })
                            
                           
                            ->rawColumns(['action'])
                            ->make(true);
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('admin.product.addEdit',compact('categories'));
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->all();
       
        if(isset($inputs['image'])){
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/products'), $imageName);
            $inputs['image']=$imageName;
        }

      Product::create($inputs);
        return redirect('admin/products')->with('success', 'Products addded successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories=Category::all();
        return view('admin.product.addEdit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
  
        $inputs = $request->all();
        if(isset($inputs['image'])){
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/products'), $imageName);
            $inputs['image']=$imageName;
        }

        $product->update($inputs);
        return back()->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully!');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
}
