{{--MODAL--}}

<div id="modalFindGuest" class="modal hide">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h3>Find Guest</h3>
    </div>
    <div class="modal-body">
        <form id="searchGuestForm" class="form-horizontal">
            {{csrf_field()}}
            <div id="form-search-guest" class="step">
                <div class="control-group">
                    <label class="control-label">Filter Guest By Name or Room Number</label>
                    <div class="controls">
                        <input id="searchguest" name="query" type="text" />
                        <input type="submit" value="Search" class="btn btn-primary" />
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Room Number</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="listGuest">
            @foreach($guest as $key => $val)
                <tr class="{{($val->guest_id % 2 == 1) ? 'odd' : 'even'}} gradeX">
                    <td>{{$val->first_name.' '.$val->last_name}}</td>
                    <td>{{$val->room_number_code}}</td>
                    <td><a data-dismiss="modal" data-firstname="{{$val->first_name}}" data-lastname="{{$val->last_name}}"
                           id="guest-{{$val->guest_id}}" data-id="{{$val->guest_id}}" data-room="{{$val->room_number_id}}" data-roomCode="{{$val->room_number_code}}"
                           class="btn btn-success chooseGuest">Choose</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>