<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Product_multiple_photos;
use Carbon\Carbon;
use Image;

class ProductController extends Controller
{
    function Add_Product()
    {

        return view('admin.product.index', [
            'categories' => Category::all(),
            'products' => Product::all(),
        ]);
    }

    function AddProductPost(Request $request)
    {

        $product_id = Product::insertGetId([
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'product_price' => $request->product_price,
            'product_quantity' => $request->product_quantity,
            'product_short_description' => $request->product_short_description,
            'product_long_description' => $request->product_long_description,
            'product_thumbnail_photo' => 'photo',
            'created_at' => carbon::now(),
        ]);
        $upload_photo = $request->file('product_thumbnail_photo');
        $new_name =  $product_id . '.' . $upload_photo->getClientOriginalExtension();
        $new_uploade_location = base_path('public/uploads/product_photo/' . $new_name);
        Image::make($upload_photo)->resize(600, 622)->save($new_uploade_location);

        Product::find($product_id)->update([
            'product_thumbnail_photo' => $new_name
        ]);

        // Multiple photo uploads
        $flage = 1;
        foreach ($request->file('product_multiple_photos') as $product_multiple_photos) {
            $upload_photo = $product_multiple_photos;
            $new_name =  $product_id.'-'. $flage++ .'.' .  $upload_photo->getClientOriginalExtension();
            $new_uploade_location = base_path('public/uploads/multiple_photos/' . $new_name);
            Image::make($upload_photo)->resize(600, 550)->save($new_uploade_location);

            Product_multiple_photos::insert([
                'product_id' =>$product_id,
                'photo_name' =>$new_name,
                'created_at' =>Carbon::now()
            ]);
        }
        return back();
    }
}
