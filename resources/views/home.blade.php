@extends('layouts.master')
@section('title', 'My Recibe Book')
<style>
    .l_hide{
        display: none;
    }
</style>
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-4">
                        <button class="btn btn-md btn-primary pull-right"  id="btnNew"> New Recipe</button>
                    </div>
                    <div class="col-md-2">
                         <div class="input-group">
                            <select name="filter" id="filter" class="form-control" style="width: 100px;">
                                <option value="name">Name</option>
                                <option value="name">Type</option>
                                <option value="name">Cuisine</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input class="form-control" type="text" id="value" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="search_list()"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered" id="list" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Cuisine</th>
                            <th>Date</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New Recipe</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="" id="addForm">
            <div class="modal-body">
              <div class="success-msg"></div>
              @csrf
              <input type="hidden" name="add" id="is_add" value="1">
              <input type="hidden" name="id">

              <div class="form-group">
                <div class="row form-group">
                    <label for="" class="col-md-2">Name</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row form-group">
                    <label for="" class="col-md-2">Type</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="type">
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row form-group">
                    <label for="" class="col-md-2">Cuisine</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="cuisine">
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row form-group">
                    <label for="" class="col-md-2">Ingredients</label>
                    <div class="col-md-10">
                        <textarea class="form-control" rows="5" name="ingredients"></textarea>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row form-group">
                    <label for="" class="col-md-2">Directions</label>
                    <div class="col-md-10">
                        <textarea class="form-control" rows="5" name="directions"></textarea>
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
            </div>
           </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete this record?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="" id="deleForm">
            <input type="hidden" name="id" id="delete_id">
            <div class="modal-body">
              <div class="success-msg"></div>
              @csrf
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-danger">Confirm</button>
            </div>
           </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="recipeList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Search Result</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="hidden" name="id" id="delete_id">
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="search_list" class="table table-bordered">
                        <thead>
                            <th></th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Calories</th>
                            <th>Source</th>
                            <th>Health Labels</th>
                            <th>Ingredients</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-danger">Confirm</button>
            </div>
        </div>
      </div>
    </div>
@endsection

@section('plugins-script')
<script>
$(document).ready(function() {
    $('#btnNew').on('click', function(){
        $('#addModal').modal('show');
        $('#is_add').val(1);
    });
    $("#addForm").submit(function(event) {
        var $form = $(this).serialize();
        $('.help-block').remove();
        $('#addForm input').removeClass('has-error');

        var add = $('#is_add').val();
        if(add==1){
            var url = '{{url("api/recipe")}}';
            var method = 'POST';
        }else{
            var id = $('[name="id').val();
            var url = '{{url("api/recipe")}}'+'/'+id;
            var method = 'PUT';
        }

        $.ajax({
            type        : method, 
            url         : url, 
            data        : $form,
            dataType    : 'json',
            encode          : true
        }).done(function(data) {
            console.log(data);
            if(data.success){
                $('.success-msg').html('<div class="alert alert-success">Recipe successfully Added.</div>');
                $(".success-msg").fadeTo(2000, 500).slideUp(500, function(){
                    $(".success-msg").alert('close');
                    $('#addForm').trigger('reset'); 
                });
            }else{
                var msg = data.message.message;
                $.each( msg, function( key, value ) {
                  $('#addForm [name="'+key+'"]').addClass('has-error');
                  $('<div class="help-block">' + value + '</div>').insertAfter($('#addForm input[name="'+key+'"]'));
                });

            }
        });
        event.preventDefault();
    });

    $("#deleForm").submit(function(event) {
        var $form = $(this).serialize();
        var id = $('#delete_id').val();
        $.ajax({
            type        : 'DELETE', 
            url         : '{{url("api/recipe")}}'+'/'+id, 
            data        : $form,
            dataType    : 'json',
            encode          : true
        }).done(function(data) {
            $('.success-msg').html('<div class="alert alert-success">Recipe successfully Added.</div>');
            $("#deleteModal").fadeTo(2000, 500).slideUp(500, function(){
                $("#deleteModal").modal('hide');
            });
        });
        event.preventDefault();
    });

    $("#recipeSearch").submit(function(event) {
        var $form = $(this).serialize();

        $.ajax({
            type        : 'POST', 
            url         : '{{url("api/recipe/search")}}', 
            data        : $form,
            dataType    : 'json',
            encode          : true
        }).done(function(data) {
            $('#recipeList').modal('show');
            var content = '';
            if(data.data.length>0){
                $.each( data.data, function( key, value ) {
                    var ing = load_str_content(value['ingredientLines'], key);
                    content += '<tr>';
                        content += '<td>';
                            // content += '<button class="btn btn-md btn-info btnEdit" onclick="addtocollection('+value['id']+')"> Add to Collection </button> ';
                            content += '<a target="_blank"  class="btn btn-md btn-success" href="'+value['url']+'"> View </a> ';
                        content += '</td>';
                        content += '<td><img src="'+value['image']+'" alt="" width="100px;"></td></td>';
                        content += '<td>'+value['label']+'</td>';
                        content += '<td>'+value['calories']+'</td>';
                        content += '<td>'+value['healthLabels']+'</td>';
                        content += '<td>'+ing+'</td>';
                    content += '</tr>';
                });

            }
            else{
                content += '<tr>';
                    content += '<td colspan="8" align="center">No result found.</td>';
                content += '</tr>';
            }
            $('#search_list tbody').html(content);
        });
        event.preventDefault();
    });
});


function load_str_content(ingr, key)
{
    $('.l_hide').css('display', 'none');
    var content = '';
        content += '<ul class="list-unstyled">';
        $.each( ingr, function( key, value ) {
            var clss = 'l_default';
            if(key > 2){
                clss = 'l_hide'; 
            }
             content += '<li class="'+clss+'"> <strong>&#x3e;</strong>' +value+'</li>';
        });
        content += '</ul>';
    content += '<small><u><a type="button" onclick="show_str('+key+')" id="show_hide_str_'+key+'" data-val="0"> Show More<a/></u></small>';
    return content;
}

function show_str(key)
{
    var val = $('#show_hide_str_'+key).attr('data-val');
    console.log(val);
    if(val==0){
        $('.l_hide').css('display', 'inherit');
        $('#show_hide_str_'+key).text('Show Less');
    }else{
        $('.l_hide').css('display', 'none');
        $('#show_hide_str_'+key).text('Show More');
    }
    var hide = (val==0)?1:0;
    $('#show_hide_str_'+key).attr('data-val', hide);
}
load_table();

function load_table(key = '', value='')
{
    $('#list tbody').html('');
    $.ajax({
        type        : 'POST', 
        url         : '{{url("api/recipe/list")}}', 
        dataType    : 'json',
        data        : {
                        key:key,
                        value:value,
                    },
        encode      : true
    }).done(function(data) {
        var content = '';
        if(data.data.length>0){
            $.each( data.data, function( key, value ) {
                content += '<tr>';
                    content += '<td>';
                        content += '<button class="btn btn-md btn-info btnEdit" onclick="editRecord('+value['id']+')"> Edit </button> ';
                        content += '<button class="btn btn-md btn-danger btnDelete" onclick="deleteRecord('+value['id']+')"> Delete </button>';
                    content += '</td>';
                    content += '<td>'+value['name']+'</td>';
                    content += '<td>'+value['type']+'</td>';
                    content += '<td>'+value['cuisine']+'</td>';
                    content += '<td>'+value['created_at']+'</td>';
                content += '<td>'+value['notes']+'</td>';

                content += '</tr>';
            });
        }else{
            content += '<tr>';
                content += '<td colspan="6" align="center">No result found.</td>';
            content += '</tr>';
        }
        $('#list tbody').html(content);
    });
}

function editRecord(id)
{
    $('#addModal').modal('show');
    $('#is_add').val(0);
    $.ajax({
        type        : 'GET', 
        url         : '{{url("api/recipe")}}'+'/'+id, 
        dataType    : 'json',
        encode      : true
    }).done(function(data) {
        if(data.success){
            var record = data.data;
            $.each( record, function( key, value ) {
              $('#addForm [name="'+key+'"]').val(value);
            });
        }
    });
}

function deleteRecord(id)
{
     $('.success-msg').html('');
     $('#deleteModal').modal('show');
     $('#delete_id').val(id);
}

function search_list(){
    var value = $('#value').val();
    var key = $('#filter').val();
    load_table(key, value);
}



</script>
@stop
