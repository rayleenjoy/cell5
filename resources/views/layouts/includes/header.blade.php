<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.html">My RecipeCollection</a>
 
  	<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" id="recipeSearch">
  		@csrf
        <div class="input-group">
            <input class="form-control" type="text" name="search" placeholder="Search for a Recipe across the web" aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" name="search"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>
</nav>