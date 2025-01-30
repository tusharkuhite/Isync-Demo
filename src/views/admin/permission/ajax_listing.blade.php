@if(($data->count()))
@foreach($data as $key => $value)
<tr>
   @if(isset($permission) && $permission != null && $permission->eWrite == "Yes" || $permission->eDelete == "Yes")
   <td>
      <div class="checkbox">
         <input id="vUniqueCode_{{$value->vUniqueCode}}" type="checkbox" name="vUniqueCode[]" class="checkboxall form-check-input" value="{{$value->vUniqueCode}}">
         <label for="vUniqueCode_{{$value->vUniqueCode}}">&nbsp;</label>
      </div>
   </td>
   @endif
   
   <td class="text-center">
      @if(!empty($value->vModule))
      {{$value->vModule}}
      @else
      {{ "N/A" }}
      @endif
   </td>
   <td class="text-center text-nowrap">
      @if(!empty($value->vRole))
      {{$value->vRole}}
      @else
      {{ "N/A" }}
      @endif
   </td>

   <td class="text-center"><span class=" @if($value->eRead == 'Yes')badge bg-label-info me-1 @elseif($value->eRead == 'No' || $value->eRead == NULL) badge bg-label-secondary me-1 @endif">@if(!empty($value->eRead)){{$value->eRead}}@else{{ "N/A" }}@endif</span>
   </td>
   <td class="text-center"><span class=" @if($value->eWrite == 'Yes')badge bg-label-info me-1 @elseif($value->eWrite == 'No' || $value->eWrite == NULL) badge bg-label-secondary me-1 @endif">@if(!empty($value->eWrite)){{$value->eWrite}}@else{{ "N/A" }}@endif</span>
   </td>
   <td class="text-center"><span class=" @if($value->eDelete == 'Yes')badge bg-label-info me-1 @elseif($value->eDelete == 'No' || $value->eDelete == NULL) badge bg-label-secondary me-1 @endif">@if(!empty($value->eDelete)){{$value->eDelete}}@else{{ "N/A" }}@endif</span>
   </td>
  
   <td> 
      @if(isset($permission) && $permission != null && ($permission->eWrite == "Yes" || $permission->eDelete == "Yes"))
      <div class="bottom-btn text-center">
         @if($permission->eWrite == "Yes")
         <a href="{{url('admin/permission/edit',$value->vUniqueCode)}}" data-toggle="tooltip_edit" title="Edit Data" data-id="{{$value->vUniqueCode}}" class="btn btn-outline-primary btn-sm me-1"><i class='bx bx-edit-alt pt-1 pb-1'></i></a>
         @endif
         @if($permission->eDelete == "Yes")
         <a href="javascript:void(0)" data-id="{{$value->vUniqueCode}}" data-toggle="tooltip_delete"  title="Delete Data" class="btn btn-outline-danger btn-sm delete"><i class='bx bx-trash pt-1 pb-1' ></i></a>
         @endif
      </div>
      @endif
   </td>
</tr>
@endforeach
@if(!empty($paging))
<tr>
   <td colspan="7" align="center">
      <div  class="paginations">
         <?php echo $paging;?>
      </div>
   </td>
</tr>
@endif
@else
<tr class="text-center">
   <td colspan="9">No Record Found</td>
</tr>
@endif
<input type="hidden" id="Count" class="count" value="{{$PermissionData}}">



<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip_edit"]').tooltip({delay: { "show": 500, "hide": 100 }})
  $('[data-toggle="tooltip_delete"]').tooltip({delay: { "show": 500, "hide": 100 }})
})
</script>

