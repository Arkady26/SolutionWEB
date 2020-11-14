@php
$booking = App\Models\Bookings::find(app('request')->input('bookingID'));
@endphp
@if($setting['form-method'] =='native')
<div class="box box-primary">
	<div class="box-header with-border">
			<div class="box-header-tools pull-right " >
				<a href="javascript:void(0)" class="collapse-close pull-right btn btn-xs btn-default" onclick="ajaxViewClose('#{{ $pageModule }}')"><i class="fa fa fa-times"></i></a>
			</div>
	</div>

	<div class="box-body">
@endif
			{!! Form::open(array('url'=>'booktermsconditions/save/'.\App\Library\SiteHelpers::encryptID($row['bookingID']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ','id'=> 'booktermsconditionsFormAjax')) !!}
			<div class="col-md-12">
				<script type="text/javascript" src="{{url('assets/js/jquery.signature.js')}}"></script>
				<link href="{{url('assets/css/jquery.signature.css')}}" rel="stylesheet">
				<style>
				.kbw-signature { width: 100%; height: 400px; }
				</style>
						<fieldset>
							<legend> {{Lang::get('core.booktermsconditions')}}</legend>
							{!! Form::hidden('roomID', $row['roomID']) !!}
							{!! Form::hidden('bookingID', app('request')->input('bookingID')) !!}
								<div class="form-group  " >
								<label for="Term & Conditions" class=" control-label col-md-4 text-left"> {{ Lang::get('core.tandc') }} <span class="asterix"> * </span></label>
								<div class="col-md-3">
									<select name='policyandterms' rows='5' id='policyandterms' class='select2 ' required  ></select>
								 </div>
								 <div class="col-md-2">

								 </div>
								</div>
            </fieldset>
			</div>




			<div style="clear:both"></div>
			<input style="display:none" name="esign" id="esign"/>
			<input style="display:none" name="esign_json" id="esign_json"/>
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

<script>
$(document).ready(function() {
	$('.editor').summernote();
	$('.tips').tooltip();
	$(".select2").select2({ width:"100%" , dropdownParent: $('#mmb-modal-content')});
	$('.removeMultiFiles').on('click',function(){
		var removeUrl = '{{ url("booktermsconditions/removefiles?file=")}}'+$(this).attr('url');
		$(this).parent().remove();
		$.get(removeUrl,function(response){});
		$(this).parent('div').empty();
		return false;
	});
	$("#policyandterms").jCombo("{!! url('tours/comboselect?filter=termsandconditions:tandcID:title&limit=WHERE:status:=:1') !!}",
	{  selected_value : '{{$booking['policyandterms']}}' });
	var form = $('#booktermsconditionsFormAjax');
	form.parsley();
	form.submit(function(event){

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
        setTimeout(location.reload.bind(location), 3000);
	} else {
		notyMessageError(data.message);
		$('.ajaxLoading').hide();
		return false;
	}
}
$('#defaultSignature').signature();
</script>
