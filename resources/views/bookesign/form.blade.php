@php
	$mytime = Carbon\Carbon::now();
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
			{!! Form::open(array('url'=>'bookesign/save/'.\App\Library\SiteHelpers::encryptID($row['roomID']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ','id'=> 'bookesignFormAjax')) !!}
			<div class="col-md-12">
				<script type="text/javascript" src="{{url('assets/js/jquery.signature.js')}}"></script>
				<link href="{{url('assets/css/jquery.signature.css')}}" rel="stylesheet">
				<style>
				.kbw-signature { width: 100%; height: 200px; }
				</style>
						<fieldset><legend> {{Lang::get('core.bookesign')}}</legend>
								{!! Form::hidden('roomID', $row['roomID']) !!}
                {!! Form::hidden('bookingID', app('request')->input('bookingID')) !!}
								<p> {{sprintf(Lang::get('core.signedby'), \App\Library\SiteHelpers::formatLookUp($booking->travellerID,'travellerID','1:travellers:travellerID:nameandsurname'), date("d-m-Y", strtotime($mytime)))}}<p>
								<div id="sig" class="kbw-signature">
								</div>
            </fieldset>
			</div>




			<div style="clear:both"></div>
			<input style="display:none" name="esign" id="esign"/>
			<input style="display:none" name="esign_json" id="esign_json"/>
			<div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">
					<button type="button" class="btn btn-success btn-sm" id="clear">  {{ Lang::get('core.clear') }} </button>
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
	var sig = $('#sig').signature({syncField: '#esign'});
	sig.signature('toJSON');
	$('#disable').click(function() {
		var disable = $(this).text() === 'Disable';
		$(this).text(disable ? 'Enable' : 'Disable');
		sig.signature(disable ? 'disable' : 'enable');
	});
	$('#clear').click(function() {
		sig.signature('clear');
	});
	$('#svg').click(function() {
		alert(sig.signature('toSVG'));
	});
	$('.editor').summernote();
	$('.tips').tooltip();
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("bookesign/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();
			return false;
		});

	var form = $('#bookesignFormAjax');
	form.parsley();
	form.submit(function(event){
		$("#esign_json").val($("#esign").val());
		sig.signature('option', 'syncFormat', 'PNG');
		sig.signature('draw', $("#esign_json").val());
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
