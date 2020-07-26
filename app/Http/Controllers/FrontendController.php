<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Product_multiple_photos;
use PhpParser\Parser\Multiple;

class FrontendController extends Controller
{
    function index(){
        return view('frontend.index',[
            'categories' => Category::all(),
            'products'=> Product::all(),
        ]);
    }

    function ProductDetiels($Product_id){

        $category_id = Product::find($Product_id)->category_id;
        return view('admin.product.singelproduct',[
            'products_info'=> Product::find($Product_id),
            'releted_products'=>Product::where('category_id',$category_id)->where('id','!=',$Product_id)->limit(4)->get(),
            'multiple_products'=>Product_multiple_photos::where('product_id',$Product_id)->get(),
        ]);
    }

    function shop_page(){
        $categories = Category::all();
        $products = Product::all();
        return view('admin.shope',compact('categories','products'));
    }
}
