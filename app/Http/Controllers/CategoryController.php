<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(){
        return response()->json(['message'=>'la liste des categories']);
    }
    
    public function store(Request $request){
        //
        $request->validate([
            'name'=>'required|min:3'
        ]);
        

        $categorie=Category::create([
            'name'=>$request->name
        ]);

        return response()->json(['message'=>'categorie a été crée avec succées','caotegorie'=>$categorie],201);
    }

    public function destroy($id){
        $categorie=Category::find($id);
        if(!$categorie){
            return response()->json(['message'=>'aucun categorie a été trouvé'],404);
        }
        if($categorie->delete()){
            return response()->json(['message'=>'categorie a été supprimé avec succés'],200);
        }else{
            return response()->json(["message"=>'la suppression a été echoue'],500);
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'=>'required|min:3'
        ]);
        $categorie=Category::find($id);
        if(!$categorie){
            return response()->json(['message'=>'aucun categorie de cette id']);
        }
        $categorie->update([
            'name'=>$request->name
        ]);

        return response()->json(['message'=>"la modification à été fais avec succées"],200);
    }
}
