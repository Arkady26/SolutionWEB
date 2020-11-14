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
                    <label for="module_name">module_name</label>
                    {{$module_name}}
                </div>
                <div class="form-group">
                    <label for="module_title">module_tyle</label>
                    {{$type}}
                </div>
                <div class="form-group">
                    <button type="submit" name="button">submit</button>
                </div>
          </div>
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
