@if(count($cptCodes))
    @foreach($cptCodes as $cptCode)
        <tr class="text-white billingindex{{ !is_null($cptCode->id) ? $cptCode->id : '' }}">
            <td>{{ $loop->iteration }}</td>
            <td class="table-border-left">{{ !is_null($cptCode->insurance_name)? $cptCode->insurance_name : ''   }}</td>
            <td class="table-border-left">{{ !is_null($cptCode->cptcode)? $cptCode->cptcode : ''   }}</td>
            <td class="table-border-left">{{ !is_null($cptCode->par_amount)? $cptCode->par_amount : ''   }}</td>
            <td class="table-border-left">{{ !is_null($cptCode->state)? $cptCode->state : ''   }}</td>
            <td class="text-center"><a style="cursor: pointer;color:#FE0957;"   class="DeleteCpt  DeleteCpt{{ !is_null($cptCode->id) ? $cptCode->id : '' }}"  data-id="{{ !is_null($cptCode->id) ? $cptCode->id : '' }}" ><i class="fas fa-trash-alt"></i></a>
                <a style="cursor: pointer;color:#FE0957;"   data-listId="{{!is_null($cptCode->id) ? $cptCode->id:''}}"  class="commit-button DeleteCpt{{ !is_null($cptCode->id) ? $cptCode->id : '' }}"  data-id="{{ !is_null($cptCode->id) ? $cptCode->id : '' }}" ><i class="fa fa-pencil-square-o"></i></a></td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="text-center">No data found!</td>
    </tr>
@endif

