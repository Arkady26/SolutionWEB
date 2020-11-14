
@if($setting['form-method'] =='native')
<div class="box box-primary">
	<div class="box-header with-border">
			<div class="box-header-tools pull-right " >
				<a href="javascript:void(0)" class="collapse-close pull-right btn btn-xs btn-default" onclick="ajaxViewClose('#{{ $pageModule }}')"><i class="fa fa fa-times"></i></a>
			</div>
	</div>

	<div class="box-body">
@endif
			{!! Form::open(array('url'=>'packages/save_part/'.\App\Library\SiteHelpers::encryptID($row['tour_feature_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ','id'=> 'partsFormAjax')) !!}
			<div class="col-md-12">
						<fieldset><legend> {{Lang::get('core.part')}}</legend>
				{!! Form::hidden('tour_feature_id', $row['tour_feature_id']) !!}
        {!! Form::hidden('bookingID', app('request')->input('bookingID')) !!}
        <div class="form-group  " >
          <label for="Guide" class=" control-label col-md-4 text-left"> {{ Lang::get('core.guide') }} </label>
          <div class="col-md-4">
            <select name='guideID' rows='5' id='guideID' class='select2 guideID'></select>
          </div>
        </div>
        <div class="form-group  " >
          <label for="Currency" class=" control-label col-md-4 text-left"> {{ Lang::get('core.currency') }} </label>
          <div class="col-md-4">
            <select name='currencyID' rows='5' id='currencyID' class='select2 currencyID'   ></select>
           </div>
        </div>
        <div class="form-group  " >
        <label for="Tour Cost for Single room" class=" control-label col-md-4 text-left"> {{ Lang::get('core.tourcostsingle') }} </label>
        <div class="col-md-4">
          <input  type='text' name='cost_single' id='cost_single' value='' class='form-control ' />
         </div>
        </div>
        <div class="form-group  " >
        <label for="Tour Cost for Double Room " class=" control-label col-md-4 text-left"> {{ Lang::get('core.tourcostdouble') }}  </label>
        <div class="col-md-4">
          <input  type='text' name='cost_double' id='cost_double' value='' class='form-control ' />
         </div>
        </div>
        <div class="form-group  " >
        <label for="Tour Cost for Triple Room" class=" control-label col-md-4 text-left"> {{ Lang::get('core.tourcosttriple') }} </label>
        <div class="col-md-4">
          <input  type='text' name='cost_triple' id='cost_triple' value='' class='form-control ' />
         </div>
        </div>
        <div class="form-group  " >
        <label for="Tour Cost for a Child" class=" control-label col-md-4 text-left"> {{ Lang::get('core.tourcostchild') }} </label>
        <div class="col-md-4">
          <input  type='text' name='cost_child' id='cost_child' value='' class='form-control ' />
         </div>
       </div>
     </fieldset>
			</div>




			<div style="clear:both"></div>

			<div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">
					<button type="submit" class="btn btn-success btn-sm ">  {{ Lang::get('core.sb_save') }} </button>
					<button type="button" onclick="ajaxViewClose('#{{ $pageModule }}')" class="btn btn-danger btn-sm">  {{ Lang::get('core.sb_cancel') }} </button>
				</div>
			</div>
			{!! Form::close() !!}


@if($setting['form-method'] =='native')
	</div>
</div>
@endif


<script type="text/javascript">
$(document).ready(function() {

  $(".guideID").jCombo("{!! url('tourdates/comboselect?filter=guides:guideID:name&limit=WHERE:status:=:1') !!}",
  {  selected_value : '{{ $row["guideID"] }}' });
  $(".currencyID").jCombo("{!! url('tourdates/comboselect?filter=def_currency:currencyID:currency_sym|symbol&limit=WHERE:status:=:1') !!}",
  {  selected_value : '{{ $row["currencyID"] }}' });

	var form = $('#partsFormAjax');
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
$("input input[name='cost_single'], input[name='cost_double'], input[name='cost_triple'], input[name='cost_child']").TouchSpin();
</script>
