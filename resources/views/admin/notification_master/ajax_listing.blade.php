
@if(($data->count()))

@foreach($data as $key => $value)
<tr align="center" class="text-center">
	<td>
	  @if(!empty($value->vNotificationCode))
      {{ $value->vNotificationCode}}
	  @else
	  {{ "N/A" }}
	  @endif
	</td>
   <td>
	  @if(!empty($value->eEmail))
      {{ $value->eEmail}}
	  @else
	  {{ "N/A" }}
	  @endif
	</td>
	<td>
	  @if(!empty($value->eSms))
      {{ $value->eSms}}
	  @else
	  {{ "N/A" }}
	  @endif
	</td>
	<td>
	  @if(!empty($value->eInternalMessage))
      {{ $value->eInternalMessage}}
	  @else
	  {{ "N/A" }}
	  @endif
	</td>
	<td>
		<a class="btn btn-danger btn-sm delete"  data-id="{{$value->iNotificationMasterId}}" href="javascript:;"><i class="fas fa-trash"></i></a>
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