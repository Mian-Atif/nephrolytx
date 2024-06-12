<div class="panel panel-default">

    <div class="panel-body">
        <ul id="addusersortable1" class="list-group list-group-flush adduserconnectedSortable" style="width: 100%; height: 200px; overflow-x: hidden; overflow-y: scroll;">
            @foreach($doctors as $doctor)
                <li class="list-group-item" value="{{ $doctor->id }}">{{ $doctor->person->name }} | {{ $location->location_name }}
                <input type="hidden" name="location_id[]" value="{{$location->id}}">
                <input type="hidden" name="doctor_id[]" value="{{$doctor->id}}">
                </li>
            @endforeach
        </ul>
    </div>
</div>