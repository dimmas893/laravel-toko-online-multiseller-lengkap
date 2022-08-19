<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerProduct;
use App\Category;
use App\SubCategory;
use App\Brand;
use App\SubSubCategory;
use Auth;
use ImageOptimizer;

class CustomerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = CustomerProduct::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.customer.products', compact('products'));
    }

    public function customer_product_index()
    {
        $products = CustomerProduct::all();
        return view('classified_products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->user_type == "customer" && Auth::user()->remaining_uploads > 0){
            $categories = Category::all();
            return view('frontend.customer.product_upload', compact('categories'));
        }
        elseif (Auth::user()->user_type == "seller" && Auth::user()->remaining_uploads > 0) {
            $categories = Category::all();
            return view('frontend.customer.product_upload', compact('categories'));
        }
        else{
            flash(__('Your classified product upload limit has been reached. Please buy a package.'))->error();
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_product = new CustomerProduct;
        $customer_product->name = $request->name;
        $customer_product->added_by = $request->added_by;
        $customer_product->user_id = Auth::user()->id;
        $customer_product->category_id = $request->category_id;
        $customer_product->subcategory_id = $request->subcategory_id;
        $customer_product->subsubcategory_id = $request->subsubcategory_id;
        $customer_product->brand_id = $request->brand_id;
        $customer_product->conditon = $request->conditon;
        $customer_product->location = $request->location;
        $photos = array();

        if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/customer_products/photos');
                array_push($photos, $path);
                // ImageOptimizer::optimize(base_path('public/').$path);
            }
            $customer_product->photos = json_encode($photos);
        }

        if($request->hasFile('thumbnail_img')){
            $customer_product->thumbnail_img = $request->thumbnail_img->store('uploads/customer_products/thumbnail');
            // ImageOptimizer::optimize(base_path('public/').$customer_product->thumbnail_img);
        }

        $customer_product->unit = $request->unit;
        $customer_product->tags = implode('|',$request->tags);
        $customer_product->description = $request->description;
        $customer_product->video_provider = $request->video_provider;
        $customer_product->video_link = $request->video_link;
        $customer_product->unit_price = $request->unit_price;
        $customer_product->meta_title = $request->meta_title;
        $customer_product->meta_description = $request->meta_description;
        if($request->hasFile('meta_img')){
            $customer_product->meta_img = $request->meta_img->store('uploads/customer_products/meta');
            // ImageOptimizer::optimize(base_path('public/').$customer_product->meta_img);
        }
        $customer_product->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5));
        if($customer_product->save()){
            $user = Auth::user();
            $user->remaining_uploads -= 1;
            $user->save();
            flash(__('Product has been inserted successfully'))->success();
            return redirect()->route('customer_products.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
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
    public function edit($id)
    {
        $categories = Category::all();
        $product = CustomerProduct::find(decrypt($id));
        return view('frontend.customer.product_edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer_product = CustomerProduct::find($id);
        $customer_product->name = $request->name;
        $customer_product->status = '1';
        $customer_product->user_id = Auth::user()->id;
        $customer_product->category_id = $request->category_id;
        $customer_product->subcategory_id = $request->subcategory_id;
        $customer_product->subsubcategory_id = $request->subsubcategory_id;
        $customer_product->brand_id = $request->brand_id;
        $customer_product->conditon = $request->conditon;
        $customer_product->location = $request->location;
        $photos = array();

        if($request->has('previous_photos')){
            $photos = $request->previous_photos;
        }
        else{
            $photos = array();
        }

        if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/customer_products/photos');
                array_push($photos, $path);
            }
        }
        $customer_product->photos = json_encode($photos);

        $customer_product->thumbnail_img = $request->previous_thumbnail_img;
        if($request->hasFile('thumbnail_img')){
            $customer_product->thumbnail_img = $request->thumbnail_img->store('uploads/customer_products/thumbnail');
            // ImageOptimizer::optimize(base_path('public/').$customer_product->thumbnail_img);
        }

        $customer_product->unit = $request->unit;
        $customer_product->tags = implode('|',$request->tags);
        $customer_product->description = $request->description;
        $customer_product->video_provider = $request->video_provider;
        $customer_product->video_link = $request->video_link;
        $customer_product->unit_price = $request->unit_price;
        $customer_product->meta_title = $request->meta_title;
        $customer_product->meta_description = $request->meta_description;
        if($request->hasFile('meta_img')){
            $customer_product->meta_img = $request->meta_img->store('uploads/customer_products/meta');
            // ImageOptimizer::optimize(base_path('public/').$customer_product->meta_img);
        }
        $customer_product->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5));
        if($customer_product->save()){
            flash(__('Product has been inserted successfully'))->success();
            return redirect()->route('customer_products.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = CustomerProduct::findOrFail($id);
        if (CustomerProduct::destroy($id)) {
            if(Auth::user()->user_type == "customer" || Auth::user()->user_type == "seller"){
                flash(__('Product has been deleted successfully'))->success();
                return redirect()->route('customer_products.index');
            }
            else {
                return back();
            }
        }
    }

    public function updateStatus(Request $request)
    {
        $product = CustomerProduct::findOrFail($request->id);
        $product->status = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function updatePublished(Request $request)
    {
        $product = CustomerProduct::findOrFail($request->id);
        $product->published = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function customer_products_listing(Request $request)
    {
        return $this->search($request);
    }

    public function customer_product($slug)
    {
        $customer_product  = CustomerProduct::where('slug', $slug)->first();
        if($customer_product!=null){
            return view('frontend.customer_product_details', compact('customer_product'));
        }
        abort(404);
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $query = $request->q;
        $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
        $category_id = (Category::where('slug', $request->category)->first() != null) ? Category::where('slug', $request->category)->first()->id : null;
        $subcategory_id = (SubCategory::where('slug', $request->subcategory)->first() != null) ? SubCategory::where('slug', $request->subcategory)->first()->id : null;
        $subsubcategory_id = (SubSubCategory::where('slug', $request->subsubcategory)->first() != null) ? SubSubCategory::where('slug', $request->subsubcategory)->first()->id : null;
        $sort_by = $request->sort_by;
        $condition = $request->condition;

        $conditions = ['published' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }
        if($category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $category_id]);
        }
        if($subcategory_id != null){
            $conditions = array_merge($conditions, ['subcategory_id' => $subcategory_id]);
        }
        if($subsubcategory_id != null){
            $conditions = array_merge($conditions, ['subsubcategory_id' => $subsubcategory_id]);
        }

        $customer_products = CustomerProduct::where($conditions);

        if($query != null){
            $customer_products = $customer_products->where('name', 'like', '%'.$query.'%')->orWhere('tags', 'like', '%'.$query.'%');
        }

        if($sort_by != null){
            switch ($sort_by) {
                case '1':
                    $customer_products->orderBy('created_at', 'desc');
                    break;
                case '2':
                    $customer_products->orderBy('created_at', 'asc');
                    break;
                case '3':
                    $customer_products->orderBy('unit_price', 'asc');
                    break;
                case '4':
                    $customer_products->orderBy('unit_price', 'desc');
                    break;
                case '5':
                    $customer_products->where('conditon', 'new');
                    break;
                case '6':
                    $customer_products->where('conditon', 'used');
                    break;
                default:
                    // code...
                    break;
            }
        }

        if($condition != null){
            $customer_products->where('conditon', $condition);
        }

        $customer_products = filter_customer_products($customer_products)->paginate(12)->appends(request()->query());

        return view('frontend.customer_product_listing', compact('customer_products', 'query', 'category_id', 'subcategory_id', 'subsubcategory_id', 'brand_id', 'sort_by', 'condition'));
    }
}
