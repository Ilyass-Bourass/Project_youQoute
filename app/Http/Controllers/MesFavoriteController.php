<?php

namespace App\Http\Controllers;

use App\Models\MesFavorite;
use App\Models\Quote;
use Illuminate\Http\Request;

class MesFavoriteController extends Controller
{

    public function showMesFaorite(Request $request){
        $user_id=$request->user()->id;
        $favoriteQuoteIds = MesFavorite::where('user_id', $user_id)
        ->pluck('quote_id');

        $quotes = Quote::whereIn('id', $favoriteQuoteIds)->get();
        return response()->json($quotes);
    }
    
    public function addMesFaovorite(Request $request,$id){
        $user_id=$request->user()->id;
        $quote_id=$id;
        if($this->hasMesfavorite($user_id,$quote_id)){
            return response()->json(["cette citation déja existe dans votre favorite"]);
        }
        $quote=Quote::find($id);
        MesFavorite::create([
        'user_id'=>$user_id,
        'quote_id'=>$quote_id,
        ]);

        return response()->json(['Message'=>$quote->name." à été ajouter a votre favorites"]);
    }

    private function hasMesfavorite($user_id,$quote_id){
        return MesFavorite::where('user_id',$user_id)->where('quote_id',$quote_id)->exists();
    }

    public function deleteMesFavorite(Request $request,$quote_id){
        $user_id=$request->user()->id;
        $quote=Quote::find($quote_id);
        $favorite=MesFavorite::where('user_id',$user_id)->where('quote_id',$quote_id);
       // return response()->json([$favorite]);
       

        if($favorite->exists()){
           // return response()->json($favorite);
           $favorite->delete();
            return response()->json(['message'=>"la citation".$quote->name." à été supprimé avec succés"],200);
        }else{
            return response()->json(['message'=>'erreur lors de la supprssion'],409);
        }
    }
}
