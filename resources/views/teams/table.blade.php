<?php //usort($tableGrid, "\App\Library\SiteHelpers::_sort"); ?> <div class="col-md-12">
<div class="box box-primary">
	<div class="box-header with-border">

		@include( 'mmb/toolbar')
	</div>
	<div class="box-body">

	 {!! (isset($search_map) ? $search_map : '') !!}
<?php echo Form::open(array('url'=>'teams/delete/', 'class'=>'form-horizontal' ,'id' =>'MmbTable'  ,'data-parsley-validate'=>'' )) ;?>
<div class="table-responsive" style="min-height:300px; padding-bottom:60px; border: none !important">
	@if(count($rowData)>=1)
    <table class="table table-bordered table-striped " class="display compact" id="{{ $pageModule }}Table">
        <thead>
			<tr>
				<th width="20"> No </th>
				<th width="30"> <input type="checkbox" class="checkall" /></th>
				@if($setting['view-method']=='expand')<th width="50" style="width: 50px;">  </th> @endif
				<th width="50"><?php echo Lang::get('core.btn_action') ;?></th>
        <th><?php echo Lang::get('core.name');?></th>
				<th><?php echo Lang::get('core.type');?></th>
        <th><?php echo Lang::get('core.color');?></th>
				<th><?php echo Lang::get('core.guides');?></th>
				<th><?php echo Lang::get('core.travellers');?></th>
				<th><?php echo Lang::get('core.formula');?></th>
        <th width="50"><?php echo Lang::get('core.capacity');?></th>
				<th width="30"><?php echo Lang::get('core.status') ;?></th>
			  </tr>
        </thead>

        <tbody>
        	@if($access['is_add'] =='1' && $setting['inline']=='true')
			<tr id="form-0" >
				<td> # </td>
				<td> </td>
				@if($setting['view-method']=='expand') <td> </td> @endif
				<td >
					<button onclick="saved('form-0')" class="btn btn-success btn-xs" type="button"><i class="fa fa-play-circle"></i></button>
				</td>
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')
					<?php $limited = isset($t['limited']) ? $t['limited'] :''; ?>
						@if(\App\Library\SiteHelpers::filterColumn($limited ))
						<td data-form="{{ $t['field'] }}" data-form-type="{{ \App\Library\AjaxHelpers::inlineFormType($t['field'],$tableForm)}}">
							{!! \App\Library\SiteHelpers::transForm($t['field'] , $tableForm) !!}
						</td>
						@endif
					@endif
				@endforeach

			  </tr>
			  @endif

           		<?php $i=0; foreach ($rowData as $row) :
           			  $id = $row->id;
           		?>
                <tr class="editable" id="form-{{ $row->id }}">
					<td class="number"> <?php echo ++$i;?>  </td>
					<td ><input type="checkbox" class="ids" name="ids[]" value="<?php echo $row->id ;?>" />  </td>
					@if($setting['view-method']=='expand')
					<td><a href="javascript:void(0)" class="expandable" rel="#row-{{ $row->id }}" data-url="{{ url('teams/show/'.$id) }}"><i class="fa fa-plus-square " ></i></a></td>
					@endif
				 <td data-values="action" data-key="<?php echo $row->id ;?>"  >
					{!! \App\Library\AjaxHelpers::buttonAction('teams',$access,$id ,$setting) !!}
					{!! \App\Library\AjaxHelpers::buttonActionInline($row->id,'id') !!}

				</td>
					 <?php foreach ($tableGrid as $field) :
					 	if($field['view'] =='1') :
							$value = \App\Library\SiteHelpers::formatRows($row->{$field['field']}, $field , $row);
						 	?>
						 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
						 	@if(\App\Library\SiteHelpers::filterColumn($limited ))
								 <td align="<?php echo $field['align'];?>" data-values="{{ $row->{$field['field']} }}" data-field="{{ $field['field'] }}" data-format="{{ htmlentities($value) }}">
									 @if($field['field'] == 'status')
 												@if($row->{$field['field']})
 														 <i class="fa fa-fw fa-2x fa-check-circle text-green tips" title="" data-original-title="Active"></i>
 												@else
 														<i class="fa fa-fw fa-2x fa-exclamation-circle text-yellow tips" title="" data-original-title="Inactive"></i>
 												@endif
 									 @elseif($field['field'] == 'team_color')
 												<span style="background-color:{!! $value !!}; color:#fff; padding: 3px; border-radius:4px; display: block; height:15px"></span>
									 @elseif($field['field'] == 'team_type')
									 		@foreach($types as $type)
												@if($type->id == $row->{$field['field']})
											  	<span>{{$type->name}}</span>
												@endif
											@endforeach
										@elseif($field['field'] == 'guides')
											@foreach($guides as $a)
												 <?php
												 $guideIds = json_decode($row->{$field['field']});
												 if($guideIds)
												 foreach ($guideIds as $guideId){
													 if($guideId == $a->guideID)
														 echo "<span>".$a->name??''."</span>";
												 }
												 ?>
										 @endforeach
 									 @elseif($field['field'] == 'formula')
									 		@if($row->{$field['field']} == 0)
 												<span>{{Lang::get('core.tour')}}</span>
											@else
												<span>{{Lang::get('core.package')}}</span>
											@endif
 									 @else
 										 {!! $value !!}
 									 @endif
								 </td>
							@endif
						 <?php endif;
						endforeach;
					  ?>
                </tr>
                @if($setting['view-method']=='expand')
                <tr style="display:none" class="expanded" id="row-{{ $row->id }}">
                	<td class="number"></td>
                	<td></td>
                	<td></td>
                	<td colspan="{{ $colspan}}" class="data"></td>
                	<td></td>
                </tr>
                @endif
            <?php endforeach;?>

        </tbody>

    </table>
	@else

	<div style="margin:100px 0; text-align:center;">

		<p> {{ Lang::get('core.norecord') }} </p>
	</div>

	@endif

	</div>
	<?php echo Form::close() ;?>

	</div>
</div>

	</div>	 	                  			<div style="clear: both;"></div>  	@if($setting['inline'] =='true') @include('mmb.module.utility.inlinegrid') @endif
<script>
$(document).ready(function() {
	$('.tips').tooltip();
	$('input[type="checkbox"],input[type="radio"]').iCheck({
		checkboxClass: 'icheckbox_square-red',
		radioClass: 'iradio_square-red',
	});
	$('#{{ $pageModule }}Table .checkall').on('ifChecked',function(){
		$('#{{ $pageModule }}Table input[type="checkbox"]').iCheck('check');
	});
	$('#{{ $pageModule }}Table .checkall').on('ifUnchecked',function(){
		$('#{{ $pageModule }}Table input[type="checkbox"]').iCheck('uncheck');
	});

	$('#{{ $pageModule }}Paginate .pagination li a').click(function() {
		var url = $(this).attr('href');
		reloadData('#{{ $pageModule }}',url);
		return false ;
	});

	<?php if($setting['view-method'] =='expand') :
			echo \App\Library\AjaxHelpers::htmlExpandGrid();
		endif;
	 ?>
	 $('#{{ $pageModule }}Table').DataTable({
		 "paging": true,
		 "lengthChange": true,
		 "searching": true,
		 "ordering": false,
		 "info": false,
		 "autoWidth": false
	 });
});
</script>
<style>
.table th { text-align: none !important;  }
.table th.right { text-align:right !important;}
.table th.center { text-align:center !important;}

</style>
