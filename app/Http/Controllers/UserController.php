<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(){
        return view('users.index');
    }

    public function getData(){
        $rows = User::orderByDesc('id')->get();

        return response()->json($rows);
    }

    public function store(Request $request){
        
        $request->validate($this->rulesValidation($request));

        \DB::beginTransaction();
        try {
            $row = new User;
            $row->name  = $request->name;
            $row->email = $request->email;
            $row->password = \Hash::make($request->password);
            $row->save();
            
            \DB::commit();
            return response()->json(['message' => "The data was stored correctly"]);
            
        } catch (\Exception $e) {
              \DB::rollback();
              return response()->json([
                  "errors" => ['exception' =>[$e->getMessage()]],
                  "message" => "Internal error, contact the administrator"
              ],500);
        }
    }

    public function show($id){
        $row = User::select('id','name','email')->find($id);

        return response()->json($row);
    }

    public function update(Request $request, $id){
        
        //$validator = \Validator::make($request->all(), $this->rulesValidation($request));

        $input = $request->all();
        $row = User::find($id);
        $row->update($input);
        
        return response()->json(['message' => "The data was updated successfully"]);
    }

    public function destroy($id){        
        User::find($id)->delete();
        
        return response()->json(['message' => "The data was deleted successfully"]);
    }        

    private function rulesValidation($request){
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
