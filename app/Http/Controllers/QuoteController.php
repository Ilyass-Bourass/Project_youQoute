<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuoteResource;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Tag;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class QuoteController extends Controller
{
    use AuthorizesRequests;
    
    
    public function index()
    {
        //return response()->json(["message"=>"index"]);

        
        try{
            $this->authorize('index',Quote::class);
            $Quotes=Quote::get();
            return QuoteResource::collection($Quotes);

        }catch(AuthorizationException $e){
             return response()->json(["message"=>'Vous n avez pas la possibilité de voir ça'],403);
        }
        
    }

    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'content_text'=>'required|min:3|string',
            'source'=>'required|min:4|string',
            'auteur'=>'required|min:4|string',
            'tags' => 'required|array',
            'tags.*'=>'exists:tags,id',
            'categories' => 'required|array',
            'categories.*'=>'exists:categories,id'
        ]);

       // return response('valide');

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $quote=Quote::create([
            'content_text'=>$request->content_text,
            'source'=>$request->source,
            'user_id'=>auth()->user()->id,
            'nombre_mots'=>str_word_count($request->content_text),
            'nombre_vues'=>0,
            'auteur'=>$request->auteur
        ]);
        foreach($request->tags as $tagid){
            $quote->tags()->attach($tagid);
        }
        foreach($request->categories as $tagid){
            $quote->categories()->attach($tagid);
        }
        return new QuoteResource($quote);
    }

    
    public function show(Request $request)
    {
        $quotes=$request->user()->quotes()->get();
        if($quotes){
            return new QuoteResource($quotes);
        }
        return response()->json(['message'=>'Quote not found'],404);
    }

    public function showQuote($id){
        $quote=Quote::where('id',$id)->first();
        if($quote){
           $quote->increment('nombre_vues'); 
        }else{}
        
        return response()->json(['Quote'=>$quote]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        
        $quote=Quote::find($id);
        $this->authorize('update',$quote);
        $validator=Validator::make($request->all(),[
            'content_text'=>'required|min:3|string',
            'source'=>'required|min:6|string',
            'auteur'=>'required|min:6|string'
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        if($quote){
            $quote->update([
                'content_text'=>$request->content_text,
                'source'=>$request->source,
                'nombre_mots'=>str_word_count($request->content_text),
                'auteur'=>$request->auteur
            ]);
            return new QuoteResource($quote);
        }
        return response()->json(['message'=>'Quote not found'],404);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request,string $id)
    {
        $quote=Quote::find($id);
        $this->authorize('delete',$quote);
        //$quotes=$request->user()->quotes->where('id',$id)->first();

        
        $quote->delete();
        return response()->json(['message'=>"quote a été supprimé"],200);
    }


    public function randomQuote($NombreQuotes){
        $quote= Quote::inRandomOrder()->take($NombreQuotes)->get();
        
        return response()->json(["quote"=>$quote]);
    }


    public function fliterQuotesNombreMot($max_mots){
        //return response()->json('testFilter');
        $quotes = Quote::where('nombre_mots','<=',$max_mots)->get();
        return response()->json(['Quotes'=>$quotes]);
    }

    public function getQuotesPlusPopulaire(){
        $quotes=Quote::orderBy('nombre_vues','desc')->limit(3)->get();
        return response()->json(["quotes"=>$quotes],200);
    }

    
}
