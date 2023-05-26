@php
$iRoleId  = Session::get('iRoleId');
@endphp

@if(($data->count()))
@foreach($data as $key => $value)
<tr align="center" class="text-center">
	
    <td>
        @if(!empty($value->userName)) {{$value->userName}}
        @else
        {{ "N/A" }}
        @endif
    </td>    
    <td>
        @if(!empty($value->service)) {{$value->service}}
        @else
        {{ "N/A" }}
        @endif
    </td>    
	<td>
        @if(!empty($value->merchantReference)) {{$value->merchantReference}}
        @else
        {{ "N/A" }}
        @endif
    </td>
	<td>
        @if(!empty($value->orderId)) {{$value->orderId}}
        @else
        {{ "N/A" }}
        @endif
    </td>
    <td>
        @if(!empty($value->amount)) {{$value->amount}}
        @else
        {{ "N/A" }}
        @endif
    </td>
    <td>
        @if(!empty($value->createdAt)) {{$value->createdAt}}
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