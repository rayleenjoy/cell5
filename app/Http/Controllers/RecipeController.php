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
    public function __construct()
    {
        $this->edamam_api = new EdamamAPIController();
    }
    public function index(Request $request)
    {   
        $key = $request->key;
        $value = $request->value;
        if(empty($key)){
            $recipe = Recipe::all();
        }else{
            $recipe = Recipe::where($key, 'like', '%'.$value.'%')->get();
        }
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

         return $this->response(true, []);
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
            // $result = $this->edamam_api->get_request($search);
            $result = json_decode('[{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_b79327d05b8e5b838ad6cfd9576b30b6","label":"Chicken Vesuvio","image":"https:\/\/www.edamam.com\/web-img\/e42\/e42f9119813e890af34c259785ae1cfb.jpg","source":"Serious Eats","url":"http:\/\/www.seriouseats.com\/recipes\/2011\/12\/chicken-vesuvio-recipe.html","healthLabels":["Peanut-Free","Tree-Nut-Free"],"ingredientLines":["1\/2 cup olive oil","5 cloves garlic, peeled","2 large russet potatoes, peeled and cut into chunks","1 3-4 pound chicken, cut into 8 pieces (or 3 pound chicken legs)","3\/4 cup white wine","3\/4 cup chicken stock","3 tablespoons chopped parsley","1 tablespoon dried oregano","Salt and pepper","1 cup frozen peas, thawed"],"calories":4228.043058200812},{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_8275bb28647abcedef0baaf2dcf34f8b","label":"Chicken Paprikash","image":"https:\/\/www.edamam.com\/web-img\/e12\/e12b8c5581226d7639168f41d126f2ff.jpg","source":"No Recipes","url":"http:\/\/norecipes.com\/recipe\/chicken-paprikash\/","healthLabels":["Peanut-Free","Tree-Nut-Free","Alcohol-Free"],"ingredientLines":["640 grams chicken - drumsticks and thighs ( 3 whole chicken legs cut apart)","1\/2 teaspoon salt","1\/4 teaspoon black pepper","1 tablespoon butter \u2013 cultured unsalted (or olive oil)","240 grams onion sliced thin (1 large onion)","70 grams Anaheim pepper chopped (1 large pepper)","25 grams paprika (about 1\/4 cup)","1 cup chicken stock","1\/2 teaspoon salt","1\/2 cup sour cream","1 tablespoon flour \u2013 all-purpose"],"calories":3033.2012500008163},{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_be3ba087e212f13672b553ecfa876333","label":"Baked Chicken","image":"https:\/\/www.edamam.com\/web-img\/01c\/01cacb70890274fb7b7cebb975a93231.jpg","source":"Martha Stewart","url":"http:\/\/www.marthastewart.com\/318981\/baked-chicken","healthLabels":["Sugar-Conscious","Peanut-Free","Tree-Nut-Free","Alcohol-Free"],"ingredientLines":["6 bone-in chicken breast halves, or 6 chicken thighs and wings, skin-on","1\/2 teaspoon coarse salt","1\/2 teaspoon Mrs. Dash seasoning","1\/4 teaspoon freshly ground black pepper"],"calories":901.58575},{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_2463f2482609d7a471dbbf3b268bd956","label":"Catalan Chicken","image":"https:\/\/www.edamam.com\/web-img\/4d9\/4d9084cbc170789caa9e997108b595de.jpg","source":"Bon Appetit","url":"http:\/\/www.bonappetit.com\/columns\/breadwinner\/article\/how-to-get-your-kids-to-eat-sauce-let-them-cook-it-themselves","healthLabels":["Sugar-Conscious","Peanut-Free","Tree-Nut-Free"],"ingredientLines":["1 whole 4-pound chicken, quartered","8 slices bacon","30 cloves garlic","3 lemons, peeled, rinds thinly sliced and reserved","\u00bd cup Banyuls or another fortified dessert wine","1 cup veal or chicken stock"],"calories":3900.8},{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_4caf01683bf99ddc7c08c35774aae54c","label":"Persian Chicken","image":"https:\/\/www.edamam.com\/web-img\/8f8\/8f810dfe198fa3e520d291f3fcf62bbf.jpg","source":"BBC Good Food","url":"http:\/\/www.bbcgoodfood.com\/recipes\/7343\/","healthLabels":["Peanut-Free","Tree-Nut-Free"],"ingredientLines":["2 large onions","750 g chicken","500 g mushrooms","1 cup water","1 cup red wine","2 teaspoons chicken stock","200 ml mayonnaise","200 ml cream","small bunch of parsley","1 teaspoon curry powder"],"calories":4115.31372402923},{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_a7c379c59775dd0c7c88710f7fecff81","label":"Chicken Stew","image":"https:\/\/www.edamam.com\/web-img\/74b\/74bfb16655500083c4af92bcf45889f7.jpg","source":"Food52","url":"https:\/\/food52.com\/recipes\/83097-chicken-stew","healthLabels":["Peanut-Free","Tree-Nut-Free"],"ingredientLines":["1 pound chicken cut in pieces","4 carrots","1 onion","1 leek","1 green pepper","kosher salt","Freshly ground black pepper","Extra Virgin Olive Oil","1 cup white wine","Chicken broth"],"calories":1647.980907065869},{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_9ca0499f2ac7f1e4cae63bdf4671c1b3","label":"Chicken Liver P\u00e2t\u00e9","image":"https:\/\/www.edamam.com\/web-img\/480\/480000e79dbdd4648c4acd65630ff654.jpg","source":"Saveur","url":"http:\/\/www.saveur.com\/article\/Recipes\/Classic-Chicken-Pate","healthLabels":["Sugar-Conscious","Peanut-Free","Tree-Nut-Free"],"ingredientLines":["8 oz. chicken livers, cleaned","4 cups chicken stock","2 tbsp. rendered chicken fat or unsalted butter","\u00bd medium yellow onion, minced","1\u00bd tbsp. cognac or brandy","2 hard-boiled eggs","Kosher salt and freshly ground black pepper, to taste","Toast points, for serving"],"calories":1149.3071579176606},{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_690c3797b4f56fc1e119c14096d651c5","label":"Roast Chicken","image":"https:\/\/www.edamam.com\/web-img\/25f\/25feccd2eed4722604be4a9ffa1ac768.jpg","source":"San Francisco Gate","url":"http:\/\/www.sfgate.com\/food\/recipes\/detail.html?rid=18229&sorig=qs","healthLabels":["Sugar-Conscious","Peanut-Free","Tree-Nut-Free","Alcohol-Free","Immuno-Supportive"],"ingredientLines":["1 whole chicken, about 3-4 pounds","-- Salt and fresh-ground pepper, to taste","3 to 4 sprigs thyme, or other herbs","-- Olive oil, to taste","-- Chicken stock (optional)"],"calories":2638.8251983480804},{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_1817e7fccea9ae39d09c0e2c7fb86cb2","label":"Kreplach (Chicken Dumplings)","image":"https:\/\/www.edamam.com\/web-img\/4dd\/4dd1c7a0d8b00e8929bd6babf0968ba2.jpg","source":"Tasting Table","url":"https:\/\/www.tastingtable.com\/entry_detail\/chefs_recipes\/10154\/Matzo_balls_watch_your_back.htm","healthLabels":["Peanut-Free","Tree-Nut-Free","Alcohol-Free"],"ingredientLines":["1\u00bd teaspoons canola oil","\u00bd small shallot, finely chopped","1 cup (about \u00bd pound) raw, boneless chicken meat (preferably from 3 boneless chicken thighs), roughly chopped","\u2154 cup (about \u00bc pound) chicken skin and fat (reserved from the 3 chicken thighs)","2 chicken livers (optional)","2 garlic cloves, finely chopped","\u00bc cup finely chopped chives, plus extra for serving","1\u00bc teaspoons kosher salt","\u00be teaspoon freshly ground black pepper","30 to 34 square wonton wrappers","8 cups store-bought or homemade chicken broth"],"calories":4387.196994575062},{"uri":"http:\/\/www.edamam.com\/ontologies\/edamam.owl#recipe_a6ee2e431ba83557209f48e1cf194f2f","label":"Chicken cacciatore","image":"https:\/\/www.edamam.com\/web-img\/2ca\/2ca946a40338e9b93c1d14dec518e1b8.jpg","source":"BBC","url":"http:\/\/www.bbc.co.uk\/food\/recipes\/chickenalocacciatore_70349","healthLabels":["Peanut-Free","Tree-Nut-Free"],"ingredientLines":["8 tbsp olive oil","1 onion, sliced","2 celery stalks, roughly chopped","2 medium carrots, roughly chopped","6 chicken breasts, or chicken thighs, bones removed","175ml\/6fl oz white wine","3 tbsp tomato pur\u00e9e","500ml\/17 fl oz chicken stock","2 bay leaves","2-3 sage leaves","1 rosemary sprig","250g\/9oz easy-cook polenta","Knob of butter","25g\/1oz parmesan"],"calories":4447.802702966512}]');
        }

        return $this->response(true, $result);
    }
}
