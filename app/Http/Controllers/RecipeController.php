<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Recipe;
use App\Http\Resources\Recipe as RecipeResource;
use App\Http\Resources\RecipeCollection;
use App\Http\Controllers\EdamamAPIController;

class RecipeController extends Controller
{
    protected $protected_default_row = 5;

    public function __construct()
    {
        $this->edamam_api = new EdamamAPIController();
    }

    public function index(Request $request)
    {   
        $key = $request->key;
        $value = $request->value;
        $paginate = intval($request->page_limit) ?? 5;

        if(empty($key)){
            $recipe = Recipe::orderBy('updated_at', 'desc');
        }else{
            $recipe = Recipe::where($key, 'like', '%'.$value.'%');
        }
        $recipe = $recipe->paginate($paginate);
        $collection = RecipeCollection::make($recipe);
        return $this->response(true, $collection);
    }

    public function store(Request $request)
    {
    	$validator = \Validator::make($request->all(), [
            'name' => 'required|max:100|unique:recipe,name',
            'cuisine' => 'required',
            'ingredients' => 'required'
        ]);

        if ($validator->fails()) {
        	return $this->response(false, [], ['error_code' => 0, 'message' => $validator->messages()]);
        }

        DB::beginTransaction();
            $recipe = Recipe::create($request->all());
        DB::commit();

        return $this->response(true, new RecipeResource($recipe));
    }

    public function show($id)
    {
        return $this->response(true, new RecipeResource(Recipe::findOrFail($id)));
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:100|unique:recipe,name,'.$id,
            'cuisine' => 'required',
            'ingredients' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response(false, [], ['error_code' => 0, 'message' => $validator->messages()]);
        }

        DB::beginTransaction();
            Recipe::findOrFail($id)->update($request->all());
        DB::commit();

         return $this->response(true, new RecipeResource(Recipe::find($id)));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
            $recipe = Recipe::findOrFail($id);
            $recipe->delete();
        DB::commit();

        return $this->response(true, []);
    }

    public function edamam_search(Request $request){
        $search = $request->search;
        $result = [];
        if(!empty($search)){
            $result = $this->edamam_api->get_request($search);
        }

        return $this->response(true, $result);
    }
}
