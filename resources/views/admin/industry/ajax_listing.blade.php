@php
$iRoleId  = Session::get('iRoleId');
@endphp

@if(($data->count()))
@foreach($data as $key => $value)

<tr align="center" class="text-center">
	<td>
        <div class="checkbox">
            <input id="vUniqueCode_{{$value->vUniqueCode}}" type="checkbox" name="vUniqueCode[]" class="checkboxall" value="{{$value->vUniqueCode}}">
            <label for="vUniqueCode_{{$value->vUniqueCode}}">&nbsp;</label>
        </div>
    </td>
    <td>
        @if(!empty($value->vImage))
        <img alt="{{$value->vImage}}" class="img-fluid" style="height: 35px;" src="{{asset('uploads/industry/'.$value->vImage)}}"></td>
        @else
        <img alt="no-image" class="img-fluid" style="height: 35px;" src="{{asset('uploads/default/no-image.png')}}"></td>
        @endif
	<td class="white-space">
        @if(!empty($value->vName))
        {{$value->vName}}
        @if($value->eShowHomePage == 'Yes')
            {{'(Home)'}}
        @endif
        @else
        {{ "N/A" }}
        @endif
    </td>
	<td>
        @if(!empty($value->eStatus))
        <span class="badge @if($value->eStatus == 'Active') badge-success @else badge-danger @endif">{{$value->eStatus}}</span>
        @else
        {{ "N/A" }}
        @endif
    </td>

	<td class="white-space">
		<a class="btn btn-info btn-sm" href="{{url('admin/industry/edit',$value->vUniqueCode)}}"><i class="fas fa-pencil-alt"></i></a>
        @if($value->eIsDeleted == 'Yes')
        <a class="btn btn-success btn-sm recover"  data-id="{{$value->vUniqueCode}}" href="javascript:;"><i class="fa fa-reply"></i></a>
        @else
		<a class="btn btn-danger btn-sm delete"  data-id="{{$value->vUniqueCode}}" href="javascript:;"><i class="fas fa-trash"></i></a>
        @endif
	</td>
</tr>
@endforeach
<tr>
    <td colspan="7" align="center">
        <div  class="paginations">
            <?php echo $paging;?>
        </div>
    </td>
</tr>
@else
<tr class="text-center">
	<td colspan="9">No Record Found</td>
</tr>
@endif