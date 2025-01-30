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
      @if(!empty($value->ePanel))
      {{$value->ePanel}}
      @else
      {{ "N/A" }}
      @endif
   </td>
   <td class="text-left">
      @if(!empty($value->vTitle))
          @if(strlen($value->vTitle) >= 35)
            {{strip_tags(substr($value->vTitle, 0, 35))}} {{"..."}}
          @else
            {{strip_tags($value->vTitle)}}
          @endif
      @else
          {{ "N/A" }}
      @endif
   </td>
   <td class="text-left">
      @if(!empty($value->vController))
          @if(strlen($value->vController) >= 35)
            {{strip_tags(substr($value->vController, 0, 35))}} {{"..."}}
          @else
            {{strip_tags($value->vController)}}
          @endif
      @else
          {{ "N/A" }}
      @endif
   </td> 
   <td class="text-center">
      @if(!empty($value->vMethod))
      {{$value->vMethod}}
      @else
      {{ "N/A" }}
      @endif
   </td>

   <td class="text-center">
      @if(!empty($value->vSlug))
      {{$value->vSlug}}
      @else
      {{ "N/A" }}
      @endif
   </td>

   <!-- <td class="text-center"><span class=" @if($value->eStatus == 'Active')badge bg-label-primary me-1 @else badge bg-label-danger me-1 @endif">{{$value->eStatus}}</span>
   </td> -->

   <td>
      @if(isset($permission) && $permission != null && ($permission->eWrite == "Yes" || $permission->eDelete == "Yes"))
      <div class="bottom-btn text-center">
         @if($permission->eWrite == "Yes")
         <a href="{{route('admin.meta.edit',$value->vUniqueCode)}}" data-toggle="tooltip_edit" title="Edit Data" data-id="{{$value->vUniqueCode}}" class="btn btn-outline-primary btn-sm me-1"><i class='bx bx-edit-alt pt-1 pb-1'></i></a>
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
<input type="hidden" id="Count" class="count" value="{{$MetaData}}">



<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip_edit"]').tooltip({delay: { "show": 500, "hide": 100 }})
  $('[data-toggle="tooltip_delete"]').tooltip({delay: { "show": 500, "hide": 100 }})
})
</script>
