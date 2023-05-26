
@if(($data->count()))
@foreach($data as $key => $value)
<tr align="center" class="text-center">
	<td>
        <div class="checkbox">
			<input id="iContactUs_{{$value->iContactUs}}" type="checkbox" name="iContactUs[]" class="checkboxall" value="{{$value->iContactUs}}">
            <!-- <label for="iContactUs_{{$value->iContactUs}}">&nbsp;</label> -->
        </div>
    </td>
	<td>
	  @if(!empty($value->vName))
      	{{ $value->vName}}
	  @else
	  	{{ "N/A" }}
	  @endif
	</td>
   <td>
	  @if(!empty($value->vEmail))
      	{{ $value->vEmail}}
	  @else
	  	{{ "N/A" }}
	  @endif
	</td>
	<!-- <td>
	  @if(!empty($value->vPhone))
      	{{ $value->vPhone}}
	  @else
	  	{{ "N/A" }}
	  @endif
	</td> -->
	<td>
	  @if(!empty($value->tComments))
      	{{ $value->tComments}}
	  @else
	  	{{ "N/A" }}
	  @endif
	</td>
	<td>	
		@if($value->eIsDeleted == 'Yes')
			<a class="btn btn-success btn-sm recover"  data-id="{{$value->iContactUs}}" href="javascript:;"><i class="fa fa-reply"></i></a>
		@else
			<a class="btn btn-danger btn-sm delete"  data-id="{{$value->iContactUs}}" href="javascript:;"><i class="fas fa-trash"></i></a>
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