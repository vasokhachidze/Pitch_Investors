@if(($data->count()))
@foreach($data as $key => $value)
<tr align="center" class="text-center">
	<td>
        <div class="checkbox">
            <input type="checkbox" name="pagesettingID[]" id="pagesettingID_{{$value->iPageSettingId}}" value="{{$value->iPageSettingId}}" class="form-check-input checkboxall" />
        </div>
    </td>
	<td>{{$value->vTitle}}</td>
	<td><span class="badge @if($value->eStatus == 'Active') badge-success @else badge-danger @endif">{{$value->eStatus}}</span></td>
	<td>
			<a class="btn btn-info btn-sm" href="{{url('admin/pageSetting/edit',$value->iPageSettingId)}}"><i class="fas fa-pencil-alt"></i></a>
			<a class="btn btn-danger btn-sm delete"  data-id="{{$value->iPageSettingId}}" href="javascript:;"><i class="fas fa-trash"></i></a>
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