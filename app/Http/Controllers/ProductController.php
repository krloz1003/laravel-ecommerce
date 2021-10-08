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

    public function update(Request $request, $id){
        $input = $request->all();
        $row = Product::find($id);
        $row->update($input);
        
        return response()->json(['message' => "The data was updated successfully"]);
    }

    public function destroy($id){        
        Product::find($id)->delete();
        return response()->json(['message' => "The data was deleted successfully"]);
    }
}
