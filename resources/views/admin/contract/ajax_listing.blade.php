@php
$iRoleId  = Session::get('iRoleId');
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
        @if(!empty($value->contractSenderName)) {{$value->contractSenderName}}
        @else
        {{ "N/A" }}
        @endif
    </td>    
	<td>
        @if(!empty($value->contractReceiverName)) {{$value->contractReceiverName}}
        @else
        {{ "N/A" }}
        @endif
    </td>
    <td>
        @if(!empty($value->vContractAmount)) {{$value->vContractAmount}}
        @else
        {{ "N/A" }}
        @endif
    </td>
    <td>
        @if(!empty($value->vContractAmount)) {{$value->vCommissionAmount}}
        @else
        {{ "N/A" }}
        @endif
    </td>
    <td>
        @if(!empty($value->vContractAmount)) {{$value->iContractPercentage}}
        @else
        {{ "N/A" }}
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