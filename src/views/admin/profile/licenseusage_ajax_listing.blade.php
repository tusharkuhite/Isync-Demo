@if(($data->count()))
@foreach($data as $key => $value)
<tr>
    <td class="text-left">
        @if(!empty($value->Survey))
            @if(strlen($value->Survey) >= 60)
                {{substr($value->Survey, 0, 60)}} {{"..."}}
            @else
                {{$value->Survey}}
            @endif
            @else
                {{ "N/A" }}
        @endif
    </td>
    <td class="text-left">
        @if(!empty($value->pFirstname)&& !empty($value->pLastname))
            @if(strlen($value->pFirstname) >= 60 && strlen($value->pLastname) >= 60)
                {{substr($value->pFirstname, 0, 60)}} {{substr($value->pLastname, 0, 60)}} {{"..."}}
            @else
                {{$value->pFirstname}} {{$value->pLastname}}
            @endif
            @else
                {{ "N/A" }}
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
<input type="hidden" id="Count" class="count" value="{{$LicenseUsageData}}">
<input type="hidden" id="remaining_total" class="remaining_total" value="{{$remaining_license}}">
</script>
