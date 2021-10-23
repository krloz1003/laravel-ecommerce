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
        $rows = Product::with('media')->orderByDesc('id')->get();

        return response()->json($rows);
    }

    public function store(Request $request){
        
        $request->validate($this->rulesValidation($request));


        \DB::beginTransaction();
        try {
            $row = new Product;
            $row->name          = $request->name;
            $row->description   = $request->description;
            $row->price         = $request->price;
            $row->save();

            if($request->hasFile('picture') && $request->file('picture')->isValid()){
                $row->addMediaFromRequest('picture')->toMediaCollection('picture');
            }
            
            \DB::commit();
            return response()->json(['message' => "The data was stored correctly", 'row' => $row]);
            
        } catch (\Exception $e) {
              \DB::rollback();
              return response()->json([
                  "errors" => ['exception' =>[$e->getMessage()]],
                  "message" => "Internal error, contact the administrator"
              ],500);
        }
    }

    public function show($slug){
        $row = Product::select('id','name','description', 'price')
                        ->with('media')
                        ->where('slug',$slug)
                        ->first();

        return response()->json($row);
    }

    public function update(Request $request, $id){
        
        //$validator = \Validator::make($request->all(), $this->rulesValidation($request));

        $input = $request->all();
        $row = Product::find($id);
        $row->update($input);
        
        return response()->json(['message' => "The data was updated successfully"]);
    }

    public function destroy($id){        
        Product::find($id)->delete();
        
        return response()->json(['message' => "The data was deleted successfully"]);
    }

    private function rulesValidation($request){
        return [
            'name'          => 'required|min:7|max:50',
            'description'   => 'required|min:10|max:250',
            'price'         => 'required|numeric|between:0,999.99',

        ];
    }
}
