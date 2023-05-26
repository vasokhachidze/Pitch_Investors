@php
$iRoleId  = Session::get('iRoleId');
@endphp

@if(($data->count()))
@foreach($data as $key => $value)
<tr align="center" class="text-center">
	
    <td>
        @if(!empty($value->connectionSenderName)) {{$value->connectionSenderName}}
        @else
        {{ "N/A" }}
        @endif
    </td>    
	<td>
        @if(!empty($value->connectionReceiverName)) {{$value->connectionReceiverName}}
        @else
        {{ "N/A" }}
        @endif
    </td>
	<td>
        @if(!empty($value->eReceiverProfileType)) {{$value->eReceiverProfileType}}
        @else
        {{ "N/A" }}
        @endif
    </td>
    <td>
        @if(!empty($value->vSenderProfileTitle)) {{$value->vSenderProfileTitle}}
        @else
        {{ "N/A" }}
        @endif
    </td>
    <td>
        @if(!empty($value->vReceiverProfileTitle)) {{$value->vReceiverProfileTitle}}
        @else
        {{ "N/A" }}
        @endif
    </td>
    <td>
        @if(!empty($value->dtAddedDate)) {{$value->dtAddedDate}}
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