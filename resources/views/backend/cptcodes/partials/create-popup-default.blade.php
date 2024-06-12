<div class="modal-body">
    {{ Form::open(['route' => 'admin.cpt-default-store', 'class' => 'form', 'role' => 'form', 'method' => 'post','id' => 'cptCode']) }}
    <div>
        <label>cpt Code:</label>
        {{ Form::text('cpt_code', null, ['class' => 'form-control', 'placeholder' => 'Enter Cpt Code', 'required' => 'required']) }}

    </div>

    <div class="mt-3">
        <label>Amount</label>
        {{ Form::number('par_amount', null, ['class' => 'form-control', 'placeholder' => 'Enter  Amount', 'step' => '0.01', 'required' => 'required' ]) }}
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
