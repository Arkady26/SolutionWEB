@extends('layouts.app')

@section('content')

    <section class="content-header">
      <h1>
        Module Management
      </h1>
    </section>

  <div class="content">
	<div class="box box-primary">
      <div class="box-body">
      <form class="" action="{{url('/mmb/module/create')}}" method="post">
      @csrf
       <div class="row">
            <div class="form-group">
                <label for="tables">tables</label>
                <select class="form-control form-lm" name="tables">
                    @foreach($tables as $table)
                      <option value="{{$table}}">{{$table}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="module_name">module_name</label>
                <input type="text" name="module_name" value="">
            </div>
            <div class="form-group">
                <label for="module_title">module_title</label>
                <input type="text" name="module_title" value="">
            </div>
            <div class="form-group">
                <label for="module_note">module_note</label>
                <textarea type="text" name="module_note"></textarea>
            </div>
            <div class="form-group">
                <label for="module_db">module_db</label>
                <input type="text" name="module_db" value="">
            </div>
            <div class="form-group">
                <label for="sql_select">sql_select</label>
                <textarea type="text" name="sql_select"></textarea>
            </div>
            <div class="form-group">
                <label for="sql_where">sql_where</label>
                <textarea type="text" name="sql_where"></textarea>
            </div>
            <div class="form-group">
                <label for="sql_group">sql_group</label>
                <textarea type="text" name="sql_group"></textarea>
            </div>
            <div class="form-group">
                <label for="creation">creation</label>
                <select class="form-control form-lm" name="creation">
                    <option value="manual">manual</option>
                    <option value="auto">auto</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="button">submit</button>
            </div>
      </div>
      @if(Session::has('message'))
    		   {{ Session::get('message') }}
      @endif
      </form>
    </div>
  </div>
</div>
<style type="text/css">
	.info-box {cursor: pointer;}
    .dropdown-menu {
    max-height: 300px;
    overflow-y: auto;
    overflow-x: hidden;
}
</style>
  <script language='javascript' >
  jQuery(document).ready(function($){
    $('.post_url').click(function(e){
      e.preventDefault();
      if( ( $('.ids',$('#MmbTable')).is(':checked') )==false ){
        alert( $(this).attr('data-title') + " not selected");
        return false;
      }
      $('#MmbTable').attr({'action' : $(this).attr('href') }).submit();
    });


  })
  </script>
@stop
