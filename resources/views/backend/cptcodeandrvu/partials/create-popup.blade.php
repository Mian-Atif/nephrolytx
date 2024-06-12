<div class="modal-body">
    {{ Form::open(['route' => 'admin.cptcodes.save', 'class' => 'form', 'role' => 'form', 'method' => 'post','id' => 'cptCode']) }}

    <div class="mt-3">

        @if(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) || !is_null(Auth::user()->roles()->where('name', 'Billing Manager')->first()))
            <div class="form-group">
                {{ Form::label('name', 'Select Practice') }}
                {{--                                        {!! Form::select('practice', count($practices)?$practices->pluck('name', 'code'):'',null,['class' => 'form-control', 'required' => 'required']) !!}--}}
                {!! Form::select('practice', count($practices)?$practices->pluck('name', 'id'):'',null,['class' => 'form-control', 'required' => 'required']) !!}

            </div>
        @else

            <input type="hidden" name="practice" value="{{ !is_null(Auth::user()->practice_id) ? Auth::user()->practice_id: ''  }}">
        @endif
    </div>

    <div>
        <label>cpt Code:</label>
        {{ Form::text('cpt_code', null, ['class' => 'form-control', 'placeholder' => 'Enter Cpt Code', 'required' => 'required']) }}

    </div>

    <div class="mt-3">
        <label>Amount</label>
        <input type="number" step="0.01" name="par_amount" class="form-control" placeholder="Enter  Amount" required>
{{--        {{ Form::number('par_amount', null, ['class' => 'form-control', 'placeholder' => 'Enter  Amount', 'step'=>'0.01', 'required' => 'required']) }}--}}
    </div>

    <div class="mt-3">
        <label>State</label>
        {!! Form::select('state', $states->pluck('name','code'),null,['class' => 'form-control js-example-basic-multiple']) !!}

    </div>

    <div class="modal-footer">

        <button type="submit" class="btn btn-info">Save</button>
    </div>
    {{ Form::close() }}
</div>
