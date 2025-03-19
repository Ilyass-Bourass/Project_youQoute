<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name'=>'required|min:3'
        ]);
        $contents=explode(',',$request->name);
        foreach($contents as $content){
            Tag::create([
                'name'=>$content
            ]);
        }
        return response()->json(['message'=>'les tags sont ajouté avec succés','Content'=>$contents],201);
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'=>'required|min:3'
        ]);

        $tag=Tag::find($id);
        if($tag->update(['name'=>$request->name])){
            return response()->json(['message'=>"la modification de ".$request->name."à été fais avec suucés"],200);
        }else{
            return response()->json(["message"=>"erreor lors de la modification"],401);
        }
    }

    public function destroy($id){
        $tag=Tag::find($id);
        if(!$tag->delete()){
            return response()->json(['message'=>"erreur lors de la suppression"]);
        }
        return response()->json(['message'=>"le tag".$tag->name."à été supprimé avec succés"]); 
    }
}
