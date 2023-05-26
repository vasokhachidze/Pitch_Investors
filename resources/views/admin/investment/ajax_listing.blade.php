@php

@endphp

@if(($data->count()))
@foreach($data as $key => $value)
<tr align="center" class="text-center">
	<td>
        <div class="checkbox">
            <input id="vUniqueCode_{{$value->vUniqueCode}}" type="checkbox" name="vUniqueCode[]" class="checkboxall" value="{{$value->vUniqueCode}}">
            <!-- <label for="vUniqueCode_{{$value->vUniqueCode}}">&nbsp;</label> -->
        </div>
    </td>
    <td>
        @if(!empty($value->vInvestmentDisplayId))
        {{$value->vInvestmentDisplayId}}
        @else
        {{ "N/A" }}
        @endif
	<td class="white-space">
        @if(!empty($value->vFirstName) && !empty($value->vLastName))
        {{$value->vFirstName}} {{$value->vLastName}}
        @if($value->eShowHomePage == 'Yes')
            {{'(Home)'}}
        @endif
        @else
        {{ "N/A" }}
        @endif
    </td>
	<td>
        @if(!empty($value->vEmail))
      
        {{ strtolower(trans($value->vEmail))}}
        @else
        {{ "N/A" }}
        @endif
    </td>
	<td class="white-space"> 
        @if(!empty($value->vPhone))
        {{$value->vPhone}}
        @else
        {{ "N/A" }}
        @endif
    </td>
	<td><span class="badge @if($value->eStatus == 'Active') badge-success @else badge-danger @endif">{{$value->eStatus}}</span></td>
    <td>
         @if($value->eAdminApproval == 'Approved')
        <p class="text-success">{{'Approved'}}</p>
        @elseif($value->eAdminApproval == 'Pending')
        <a class="btn btn-warning btn-sm Approved"  data-id="{{$value->vUniqueCode}}" data-name="{{$value->vFirstName}} {{$value->vLastName}}" data-email="{{$value->vEmail}}" href="javascript:;"><i class="fa fa-check"></i></a>
        <a class="btn btn-danger btn-sm Reject"  data-id="{{$value->vUniqueCode}}" data-name="{{$value->vFirstName}} {{$value->vLastName}}" data-email="{{$value->vEmail}}" href="javascript:;"><i class="fa fa-times"></i></a>
        @elseif($value->eAdminApproval == 'Reject')
        <a class="btn btn-danger btn-sm"  data-id="{{$value->vUniqueCode}}" href="javascript:;"><i class="fa fa-times"></i></a>
        @endif
    </td>
	<td class="white-space">
        <a class="btn btn-info btn-sm" href="{{url('admin/investment/view',$value->vUniqueCode)}}"><i class="fas fa-eye"></i></a>
		<a class="btn btn-info btn-sm" href="{{url('admin/investment/edit',$value->vUniqueCode)}}"><i class="fas fa-pencil-alt"></i></a>
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