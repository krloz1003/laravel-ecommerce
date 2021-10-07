<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index(){
        return view('products.index');
    }
    
    public function getData(){
        $rows = Product::get();

        return response()->json($rows);
    }
}
