<table class="table table-bordered table-detail">
    <tr>
        <td class="title">Nama</td>
        <td>{{\App\Guest::getTitleName($guest->title) . ' '. $guest->first_name . ' ' . $guest->last_name}}</td>
        <td class="title">ID Number</td>
        <td>{{$guest->id_number}} ({{\App\Guest::getIdType($guest->id_type)}})</td>
    </tr>
    <tr>
        <td class="title">Birth Date</td>
        <td>{{date('j F Y', strtotime($guest->birthdate))}}</td>
        <td class="title">Birth Place</td>
        <td>{{$guest->birthplace}}</td>
    </tr>
    <tr>
        <td class="title">Religion</td>
        <td>{{ucfirst($guest->religion)}}</td>
        <td class="title">Gender</td>
        <td>{{\App\Helpers\GlobalHelper::getGender($guest->gender)}}</td>
    </tr>
    <tr>
        <td class="title">Address</td>
        <td>{{$guest->address}}</td>
        <td class="title">Country</td>
        <td>{{($guest->country_id) ? \App\Country::find($guest->country_id)->value('country_name') : ''}}</td>
    </tr>
    <tr>
        <td class="title">Email</td>
        <td>{{$guest->email}}</td>
        <td class="title">Job</td>
        <td>{{$guest->job}}</td>
    </tr>
</table>