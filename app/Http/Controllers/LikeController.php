<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Quote;

class LikeController extends Controller
{
    public function addLike(Request $request,$id){
        
        $quote=Quote::find($id);
        if(!$quote){
            return response()->json(['message'=>"cette citation n existe pas"],401);        
        }
        $user_id=$request->user()->id;
        $quote_id=$id;

        if($this->hasUserLiked($user_id,$quote_id)){
            return response()->json(['message' => 'Vous avez déjà liké cette citation'], 409);
        }

        $like=Like::create([
            'user_id'=>$user_id,
            'quote_id'=>$quote_id,
        ]);
        
        $quote->increment('nombres_likes');

        return response()->json(['message'=>'like à été ajouté avec succée','NombreLikes'=>$quote->nombres_likes]);
    }

    private function hasUserLiked($user_id,$quote_id):bool
    {
        
        return Like::where('user_id',$user_id)->where('quote_id',$quote_id)->exists();
    }

    public function deleteLike(Request $request,$id){
        $user_id=$request->user()->id;
        $quote_id=$id;
        $quote=Quote::find($id);
        $userLike=Like::where('user_id',$user_id)->where('quote_id',$quote_id);

        if($userLike->delete()){
            $quote->decrement('nombres_likes');
            return response()->json(["massage"=>"like de quote".$quote->name."à été supprimer avec succés"]);
        }else{
            return response()->json('suppréssion echoui');
        }

    }
}
