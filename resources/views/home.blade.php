@extends('layouts.master')
@section('title', 'My Recipe Collection')
<style>
    .l_hide{
        display: none;
    }
    .modal-llg{
        min-width: 1000px;
    }
</style>
@section('content')
    <div class="row col-md-12" style="margin-bottom: 20px;">
        <button class="btn btn-md btn-primary pull-right"  id="btnNew"> New Recipe</button>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            My Collection Lists
        </div>
        <div class="card-body">
            <div class="">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-4">
                        <span>Page</span>
                        <select name="" id="page" >
                        </select>
                    </div>
                    <div class="col-md-2">
                         <div class="input-group">
                            <select name="filter" id="filter" class="form-control" style="width: 100px;">
                                <option value="name">Name</option>
                                <option value="type">Type</option>
                                <option value="cuisine">Cuisine</option>
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
                            <th>Calories</th>
                            <th>Notes</th>
                            <th>Date</th>
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
      <div class="modal-dialog modal-llg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><span id="modalheader">Add</span> Recipe</h5>
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
                        <select name="type" id="" class="form-control">
                            <option value="Soup">Soup</option>
                            <option value="Appetizer">Appetizer</option>
                            <option value="Salad">Salad</option>
                            <option value="Fish">Fish</option>
                            <option value="Main">Main </option>
                            <option value="Dessert">Dessert </option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row form-group">
                    <label for="" class="col-md-2">Cuisine</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="cuisine" placeholder="Italian, American, Chinese, etc. Food">
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row form-group">
                    <label for="" class="col-md-2">Calories</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="calories">
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
              <div class="success-msg-deleted"></div>
              @csrf
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-danger" id="btnConfirmDelete">Confirm</button>
            </div>
           </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="recipeList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-llg" role="document">
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
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        $('.success-msg').html('');
         $('#addForm').trigger('reset'); 
        $('#modalheader').text('Add');
    });
    $("#addForm").submit(function(event) {
        var $form = $(this).serialize();
        $('.help-block').remove();
        $('#addForm input').removeClass('has-error');
        $('#addForm textarea').removeClass('has-error');

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
            if(data.success){
                $('.success-msg').html('<div class="alert alert-success">Recipe successfully Added.</div>');
                $(".success-msg").fadeTo(2000, 500).slideUp(500, function(){
                    $(".success-msg").alert('close');
                });
                if(add==1){
                    $('#addForm').trigger('reset'); 
                }
                load_table();
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
            $('.success-msg-deleted').html('<div class="alert alert-success">Recipe deleted successfully.</div>');
            $('#list tbody tr#row_'+id).remove();
            $('#btnConfirmDelete').attr('disabled', true);
            load_table();
        });
        event.preventDefault();
    });

    $("#recipeSearch").submit(function(event) {
        var $form = $(this).serialize();
        $('#search_list tbody').html('');
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
                    content += '<tr>';
                        content += '<td>';
                            content += '<a target="_blank"  class="btn btn-md btn-success" href="'+value['url']+'"> View </a> ';
                        content += '</td>';
                        content += '<td><img src="'+value['image']+'" alt="" width="100px;"></td></td>';
                        content += '<td>'+value['label']+'</td>';
                        content += '<td>'+value['calories']+'</td>';
                        content += '<td>'+value['healthLabels']+'</td>';
                        content += '<td>'+value['source']+'</td>';
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


function show_str(key)
{
    var val = $('#show_hide_str_'+key).attr('data-val');
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

function load_table(key = '', value='', page=1)
{
    var page_limit = 5;
    $('#list tbody').html('');
    $('#page').html('');
    $.ajax({
        type        : 'POST', 
        url         : '{{url("api/recipe/list")}}', 
        dataType    : 'json',
        data        : {
                        key:key,
                        value:value,
                        page:page,
                        page_limit:page_limit
                    },
        encode      : true
    }).done(function(result) {
        var content = '';
        if(result.data.data.length>0){
            $.each( result.data.data, function( key, value ) {
                content += '<tr  id="row_'+value['id']+'">';
                    content += '<td>';
                        content += '<button class="btn btn-md btn-info btnEdit" onclick="editRecord('+value['id']+')"> Edit </button> ';
                        content += '<button class="btn btn-md btn-danger btnDelete" onclick="deleteRecord('+value['id']+')"> Delete </button>';
                    content += '</td>';
                    content += '<td>'+value['name']+'</td>';
                    content += '<td>'+value['type']+'</td>';
                    content += '<td>'+value['cuisine']+'</td>';
                    content += '<td>'+value['calories']+'</td>';
                    content += '<td>'+value['notes']+'</td>';
                    content += '<td>'+value['created_at']+'</td>';
                content += '</tr>';
            });
            var total_pages = result.data.pagination.total_pages;
            var count = result.data.pagination.count;
            var option = '';
            for (var i = 1; i <= total_pages; i++) {
                option += '<option value="'+(i)+'" '+(page==i?'selected':'')+'>'+i+'</option>';
            }
            $('#page').append(option);
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
    $('.success-msg').html('');
    $('#addModal').modal('show');
    $('#is_add').val(0);
    $('#modalheader').text('Edit');

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
    $('.success-msg-deleted').html('');
    $('#deleteModal').modal('show');
    $('#delete_id').val(id);
    $('#btnConfirmDelete').attr('disabled', false);
}

function search_list(){
    var value = $('#value').val();
    var key = $('#filter').val();
    var page = $('#page').val();
    load_table(key, value, page);
}

$('#page').on('change', function(){
    search_list();
});

</script>
@stop
