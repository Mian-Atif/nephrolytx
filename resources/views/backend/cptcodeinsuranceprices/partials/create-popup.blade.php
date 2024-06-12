<div class="modal-body">
    @if(isset($cptCode))
        {{ Form::model($cptCode, ['route' => ['admin.cptcode-insurance-prices.update', $cptCode->id], 'method' => 'patch','id' => 'cptCode']) }}
    @else
        {{ Form::open(['route' => 'admin.cptcode-insurance-prices.store', 'class' => 'form', 'role' => 'form', 'method' => 'post','id' => 'cptCode']) }}

    @endif


        <div class="mt-3">

            @if(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) || !is_null(Auth::user()->roles()->where('name', 'Billing Manager')->first()))
                <div class="form-group">
                    {{ Form::label('name', 'Select Practice') }}
                    {{--                                        {!! Form::select('practice', count($practices)?$practices->pluck('name', 'code'):'',null,['class' => 'form-control', 'required' => 'required']) !!}--}}
                    {!! Form::select('practice', count($practices)?$practices->pluck('name', 'id'):'',null,['class' => 'form-control popup-practice', 'required' => 'required']) !!}

                </div>
            @else

                <input type="hidden" name="practice" value="{{ !is_null(Auth::user()->practice_id) ? Auth::user()->practice_id: ''  }}">
            @endif
        </div>

        <div>
        <label>Payer Name:</label>
        <select name="insurance_name" id="payer" class="form-control" required>
            <option value="">Select Payer</option>
            @if($payers->count())
                @foreach($payers as $payer)
                    @if(isset($cptCode))
                        <option value="{{ $payer->payer_name  }}" {{($cptCode->insurance_name == $payer->payer_name)?'selected':''}}>{{ $payer->payer_name  }}</option>
                    @else
                        <option value="{{ $payer->payer_name  }}">{{ $payer->payer_name  }}</option>

                    @endif
                @endforeach
            @endif
        </select>

    </div>

    <div class="mt-3">
        <label>Cpt Code</label>

        @if(isset($cptCode))
            {{ Form::text('cptcode', null, ['class' => 'form-control', 'placeholder' => 'Enter  Cpt Code', 'required' => 'required','readonly'=>true]) }}

        @else
            {{ Form::text('cptcode', null, ['class' => 'form-control', 'placeholder' => 'Enter  Cpt Code', 'required' => 'required']) }}

        @endif
    </div>

    <div class="mt-3">
        <label>Amount</label>
        {{ Form::number('par_amount', null, ['class' => 'form-control', 'placeholder' => 'Enter  Amount','step'=>'0.01', 'required' => 'required']) }}

    </div>
    <div class="mt-3">
        <label>State</label>

        <select name="state" class="form-control" required>
            <option value="">Select State</option>
            @if($states->count())
                @foreach($states as $state)
                    @if(isset($cptCode))
                        <option value="{{ $state->code  }}" {{($state->code == $cptCode->state)?'selected':''}}>{{ $state->name }}</option>
                    @else
                        <option value="{{ $state->code  }}">{{ $state->name  }}</option>

                    @endif
                @endforeach
            @endif
        </select>

    </div>

    <div class="modal-footer">

        <button type="submit" class="btn btn-info" >Save</button>
    </div>
    {{ Form::close() }}
</div>
<script>

    $(document).on("click",".popup-practice",function()
     {
        var cid = $(this).val();
        if (cid == '') {
            $('#countryResidence').attr('class', 'col-sm-6');
        }
        if (cid) {
            $.ajax({
                type: "get",
                url: "/admin/cptCodePayerPractice/"+cid,
                success: function (res) {
                    if (res) {
                        $('#countryResidence').attr('class', 'col-sm-3');
                        $('#stateLabel').attr('class', 'col-sm-3');
                        $("#payer").empty();
                        $("#payer").append('<option value="">Select Payer</option>');
                        $.each(res, function (key, value) {
                            $("#payer").append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                }
            });
        }
    });

</script>