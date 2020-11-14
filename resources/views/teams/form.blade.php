<?php
use Carbon\Carbon;
?>
@if($setting['form-method'] =='native')
<div class="box box-primary">
	<div class="box-header with-border">
			<div class="box-header-tools pull-right " >
				<a href="javascript:void(0)" class="collapse-close pull-right btn btn-xs btn-default" onclick="ajaxViewClose('#{{ $pageModule }}')"><i class="fa fa fa-times"></i></a>
			</div>
	</div>
	<div class="box-body">
@endif
			{!! Form::open(array('url'=>'teams/save/'.\App\Library\SiteHelpers::encryptID($row['id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ','id'=> 'teamsFormAjax')) !!}
			<div class="col-md-12">
				<fieldset><legend> {{ Lang::get('core.teams') }}</legend>
				{!! Form::hidden('id', $row['id']) !!}
				<div class="form-group" >
					<label for="Team Name" class=" control-label col-md-4 text-left"> {{ Lang::get('core.name') }} <span class="asterix"> * </span></label>
					<div class="col-md-4">
						<input  type='text' name='name' id='name' value='{{ $row['name'] }}' required class='form-control' />
					</div>
					<div class="col-md-2">
					</div>
					</div>
			  <div class="form-group  " >
				<label for="Team type" class=" control-label col-md-4 text-left">{{ Lang::get('core.teamtype') }}<span class="asterix"> * </span></label>
				<div class="col-md-4">
				  <select name='team_type' rows='5' id='team_type' class='form-control select2' required>
						<option value="">-- Please Select --</option>
						@foreach($teamtypes as $teamtype)
							<option value="{{$teamtype->id}}" {{$row['team_type']==$teamtype->id? "selected":""}}>{{$teamtype->name}}</option>
						@endforeach
					</select>
				 </div>
				 <div class="col-md-2">
				 </div>
			  </div>

				<div class="form-group">
					<label for="Guides" class="control-label col-md-4 text-left"> {{ Lang::get('core.guides') }} <span class="asterix"> * </span></label>
						<div class="col-md-4">
								<select name="guides[]" multiple="" rows="5" id="guides" class="parsley-validated form-control" required>
										@php
												$guideIDs = json_decode($row['guides']);
										@endphp
										@foreach($guides as $guide)
												<option {{ $guideIDs?(in_array($guide->guideID,$guideIDs)?'selected':''):''}} value="{{$guide->guideID}}">
													{{$guide->name}}
												</option>
										@endforeach
								</select>
						</div>
						<div class="col-md-2">
							<button type="button" name="button" class="btn btn-success" id="guides_modal_btn" data-toggle="modal" data-target="#guides_modal">{{ Lang::get('core.choose') }}</button>
						</div>
				</div>

			  <div class="form-group  " >
				<label for="Formula" class=" control-label col-md-4 text-left"> {{ Lang::get('core.formula') }} </label>
				<div class="col-md-6">
					<label class='radio radio-inline'>
					<input type='radio' name='formula' class="formula" id="formula" value ='0' required @if($row['formula'] == '0') checked="checked" @endif > {{ Lang::get('core.tour') }} </label>
					<label class='radio radio-inline'>
					<input type='radio' name='formula' class="formula" id="formula" value ='1' required @if($row['formula'] == '1') checked="checked" @endif > {{ Lang::get('core.package') }} </label>
				 </div>
				 <div class="col-md-2">

				 </div>
			  </div>

				<div class="" id="tour_part" style="display:none;">
					<div class="form-group  " >
					<label for="Tour_category" class=" control-label col-md-4 text-left">{{ Lang::get('core.tourcategory') }}</label>
					<div class="col-md-4">
						<select name='tour_category' rows='5' id='tour_category' class='select2'>
						</select>
					 </div>
					 <div class="col-md-2">
					 </div>
					</div>
					<div class="form-group  " >
					<label for="TourID" class=" control-label col-md-4 text-left">{{ Lang::get('core.tour') }}</label>
					<div class="col-md-4">
						<select name='tourID' rows='5' id='tourID' class='select2'>
						</select>
					 </div>
					</div>
				</div>

				<div class="" id="package_part" style="display:none;">
					<div class="form-group  " >
					<label for="Package" class=" control-label col-md-4 text-left">{{ Lang::get('core.package') }}</label>
					<div class="col-md-4">
						<select name='packageID' rows='5' id='package' class='select2'>
						</select>
					 </div>
					</div>
				</div>

			  <div class="form-group  " >
				<label for="Capacity" class=" control-label col-md-4 text-left"> {{ Lang::get('core.capacity') }} <span class="asterix"> * </span></label>
				<div class="col-md-2">
				  <input  type='text' name='capacity' id='capacity' value='{{ $row['capacity'] }}' required class='form-control ' />
				 </div>
				 <div class="col-md-2">

				 </div>
			  </div>
									  <div class="form-group  " >
										<label for="Status" class=" control-label col-md-4 text-left"> {{ Lang::get('core.status') }} <span class="asterix"> * </span></label>
										<div class="col-md-6">
											<label class='radio radio-inline'>
											<input type='radio' name='status' value ='0' required @if($row['status'] == '0') checked="checked" @endif > {{ Lang::get('core.fr_minactive') }} </label>
											<label class='radio radio-inline'>
											<input type='radio' name='status' value ='1' required @if($row['status'] == '1') checked="checked" @endif > {{ Lang::get('core.fr_mactive') }} </label>
										 </div>
										 <div class="col-md-2">

										 </div>
									  </div>
										<div class="form-group  " >
								            <label for="Team_color" class=" control-label col-md-2 text-left"> {{ Lang::get('core.color') }}</label>
												<div class="col-md-10">
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#4cc0c1' @if($row['team_color'] == '#4cc0c1') checked="checked" @endif > <a class="text-aqua" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#0073b7' @if($row['team_color'] == '#0073b7') checked="checked" @endif > <a class="text-blue" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#55ACEE' @if($row['team_color'] == '#55ACEE') checked="checked" @endif > <a class="text-light-blue" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#39cccc'  @if($row['team_color'] == '#39cccc') checked="checked" @endif > <a class="text-teal" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#ffc333'  @if($row['team_color'] == '#ffc333') checked="checked" @endif > <a class="text-yellow" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#ff851b'  @if($row['team_color'] == '#ff851b') checked="checked" @endif > <a class="text-orange" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#65bd77'  @if($row['team_color'] == '#65bd77') checked="checked" @endif > <a class="text-green" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#fb6b5b'  @if($row['team_color'] == '#fb6b5b') checked="checked" @endif > <a class="text-red" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#605ca8'  @if($row['team_color'] == '#605ca8') checked="checked" @endif > <a class="text-purple" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#999'  @if($row['team_color'] == '#999') checked="checked" @endif > <a class="text-muted" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
													<label class='radio radio-inline'>
													<input type='radio' name='team_color' value ='#001f3f'  @if($row['team_color'] == '#001f3f') checked="checked" @endif > <a class="text-navy" href="#"><i class="fa fa-square fa-lg"></i></a> </label>
								            </div>
								        </div>
									 </fieldset>
			</div>




			<div style="clear:both"></div>

			<div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">
					<button type="submit" class="btn btn-primary btn-sm "><i class="fa fa-play-circle"></i>  {{ Lang::get('core.sb_save') }} </button>
					<button type="button" onclick="ajaxViewClose('#{{ $pageModule }}')" class="btn btn-danger btn-sm"><i class="fa fa-remove "></i>  {{ Lang::get('core.sb_cancel') }} </button>
				</div>
			</div>
			{!! Form::close() !!}


@if($setting['form-method'] =='native')
	</div>
</div>
@endif
<div class="modal fade in" id="guides_modal"  role="dialog" style=" padding-right: 16px;">
    <div class="modal-dialog" style="width:1200px;">
        <div class="modal-content">
            <div class="modal-header bg-default">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{__('core.choose')}}</h4>
            </div>
            <div class="modal-body" id="edit-modal-content">
              <div class="table-responsive" style="min-height:300px; min-width:600px; padding-bottom:60px; border: none !important">
                @if(count($guides)>=1)
                  <table class="table table-striped " id="guidesTable">
                      <thead>
                      <tr>
                      <th width="10"> No </th>
                      <th width="30"></th>
                      <th>{{Lang::get('core.name')}}</th>
                      <th>{{Lang::get('core.email')}}</th>
                      <th>{{Lang::get('core.mobile')}}</th>
                      <th>{{Lang::get('core.language')}}</th>
                      <th>{{Lang::get('core.city')}}</th>
                      <th>{{Lang::get('core.country')}}</th>
                      <th width="30">{{Lang::get('core.status')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php $i = 0; foreach ($guides as $quide) :
                          $id = $quide->ticketID;
                      ?>
                        <tr class="editable" id="form-{{ $quide->ticketID }}">
                        <td class="number"> <?php echo ++$i;?>  </td>
                        <td ><input type="checkbox" class="ids" name="ids[]" value="<?php echo $quide->guideID ;?>" />  </td>
                       <td data-values="{{ $quide->name}}" data-field="name">
                           <span>{{$quide->name??''}}</span>
                       </td>
											 <td data-values="{{ $quide->email}}" data-field="email">
                           <span>{{$quide->email??''}}</span>
                       </td>
											 <td data-values="{{ $quide->mobilephone}}" data-field="mobile">
                           <span>{{$quide->mobilephone??''}}</span>
                       </td>
                       <td data-values="{{ $quide->languageID }}" data-field="languageID">
                           @foreach($languages as $a)
                               <?php
                                 if($quide->languageID == $a->languageID){
                                   echo "<span>".$a->language_name??''."</span>";
                                 }
                               ?>
                           @endforeach
                        </td>
                        <td data-values="{{ $quide->cityID }}" data-field="cityID">
                            @foreach($cities as $a)
                                <?php
                                  if($quide->cityID == $a->cityID){
                                    echo "<span>".$a->city_name??''."</span>";
                                  }
                                ?>
                            @endforeach
                         </td>
												 <td data-values="{{ $quide->countryID }}" data-field="countryID">
                             @foreach($countries as $a)
                                 <?php
                                   if($quide->countryID == $a->countryID){
                                     echo "<span>".$a->country_name??''."</span>";
                                   }
                                 ?>
                             @endforeach
                          </td>
                         <td data-values="{{ $quide->status }}" data-field="status">
                           @if($quide->status == '2')
                               <span class="label label-warning">{{ __('core.fr_pending') }}</span>
                           @elseif($quide->status == '1')
                               <span class="label label-success">{{ __('core.confirmed') }}</span>
                           @elseif($quide->status == '0')
                               <span class="label label-danger">{{ __('core.cancelled') }}</span>
                           @endif
                         </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                  </table>
                @else

                <div style="margin:100px 0; text-align:center;">
                  <p> {{ Lang::get('core.norecord') }} </p>
                </div>

                @endif
                <div class="form-group">
                    <label class="col-sm-5 text-right">&nbsp;</label>
                    <div class="col-sm-7">
                        <button type="button" id="storeBtn" class="btn btn-success btn-sm"> Save </button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> Cancel </button>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	@if($row['formula']==1)
		$("#tour_part").hide();
		$("#package_part").show();
	@else
		$("#tour_part").show();
		$("#package_part").hide();
	@endif
	$('.editor').summernote();
	$('.tips').tooltip();
	$(".select2").select2({ width:"100%" , dropdownParent: $('#teamsFormAjax')});
	$("#guides").select2({ width:"100%" , dropdownParent: $('#modal')},
	{  selected_value : '{{ $row["guides"] }}' });
	$("#tourID").jCombo("{!! url('teams/comboselect?filter=tours:tourID:tour_name') !!}&parent=tourcategoriesID:",
	{  parent: '#tour_category', selected_value : '{{ $row["tourID"] }}' });
	$("#tour_category").jCombo("{!! url('teams/comboselect?filter=def_tour_categories:tourcategoriesID:tourcategoryname') !!}",
	{  selected_value : '{{ $row["tour_category"] }}' });
	$("#package").jCombo("{!! url('teams/comboselect?filter=packages:packageID:tour_code') !!}",
	{  selected_value : '{{ $row["packageID"] }}' });
	$(".date").datetimepicker({
      format: 'yyyy-mm-dd',
      startDate: '{{ Carbon::today()->format('Y-m-d') }}',
      autoclose:true ,
      minView:2 ,
      startView:2 ,
      todayBtn:true
  });
	$('input[type="checkbox"],input[type="radio"]').iCheck({
		checkboxClass: 'icheckbox_square-red',
		radioClass: 'iradio_square-red',
	});
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("teams/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();
			return false;
		});

	var form = $('#teamsFormAjax');
	form.parsley();
	form.submit(function(){

		if(form.parsley('isValid') == true){
			var options = {
				dataType:      'json',
				beforeSubmit :  showRequest,
				success:       showResponse
			}
			$(this).ajaxSubmit(options);
			return false;

		} else {
			return false;
		}

	});
	$('#guidesTable').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": false,
		"info": false,
		"autoWidth": false
	});

});

function showRequest()
{
	$('.ajaxLoading').show();
}
function showResponse(data)  {

	if(data.status == 'success')
	{
		ajaxViewClose('#{{ $pageModule }}');
		ajaxFilter('#{{ $pageModule }}','{{ $pageUrl }}/data');
		notyMessage(data.message);
		$('#mmb-modal').modal('hide');
	} else {
		notyMessageError(data.message);
		$('.ajaxLoading').hide();
		return false;
	}
}

$("#storeBtn").click(function(){
	var ids = [];
	$('.ids').each(function(i, obj) {
		if(obj.checked)
			ids.push(obj.value);
	});
	$("#guides").val(ids);
	$("#guides").select2({ width:"100%" , dropdownParent: $('#mmb-modal-content')});
	$("#guides_modal").modal('hide');
});
$(".formula").on("ifChecked", function(){
	if($(this).val()==1){
		$("#tour_part").hide();
		$("#package_part").show();
	}else{
		$("#package_part").hide();
		$("#tour_part").show();
	}
});
$("input[name='capacity']").TouchSpin();
</script>
