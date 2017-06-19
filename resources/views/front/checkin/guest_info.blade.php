<table class="table table-bordered table-detail">
    <tr>
        <td class="title">@lang('web.name')</td>
        <td>{{\App\Guest::getTitleName($guest->title) . ' '. $guest->first_name . ' ' . $guest->last_name}}</td>
        <td class="title">@lang('web.idNumber')</td>
        <td>{{$guest->id_number}} ({{\App\Guest::getIdType($guest->id_type)}})</td>
    </tr>
    <tr>
        <td class="title">@lang('web.birthdate')</td>
        <td>{{date('j F Y', strtotime($guest->birthdate))}}</td>
        <td class="title">@lang('web.birthplace')</td>
        <td>{{$guest->birthplace}}</td>
    </tr>
    <tr>
        <td class="title">@lang('web.religion')</td>
        <td>{{ucfirst($guest->religion)}}</td>
        <td class="title">@lang('web.gender')</td>
        <td>{{\App\Helpers\GlobalHelper::getGender($guest->gender)}}</td>
    </tr>
    <tr>
        <td class="title">@lang('web.address')</td>
        <td>{{$guest->address}}</td>
        <td class="title">@lang('module.country')</td>
        <td>{{($guest->country_id) ? \App\Country::find($guest->country_id)->value('country_name') : ''}}</td>
    </tr>
    <tr>
        <td class="title">Email</td>
        <td>{{$guest->email}}</td>
        <td class="title">@lang('web.job')</td>
        <td>{{$guest->job}}</td>
    </tr>
</table>
