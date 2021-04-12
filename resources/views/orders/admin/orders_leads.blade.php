{!! $header !!}
<div class="d-flex align-items-stretch">
    {!! $sidebar !!}
    <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
            <section class="py-5">
                <div class="row">
                    @if(!empty($leads))
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-uppercase mb-0">Таблица лидов</h6>
                                    </div>
                                    <div class="card-body" style="font-size: 12px">
                                        <table class="table table-striped table-sm card-text">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Направление</th>
                                                <th>ФИО</th>
                                                <th>Сумма</th>
                                                <th>Регион</th>
                                                {{--<th>Город</th>--}}
                                                <th>Город</th>
                                                @if($role!=1)
                                                <th>Телефон</th>
                                                @endif
                                                <th>Комментарий</th>
                                                <th>Дата поступления</th>
                                                <th>Менеджер</th>
                                                <th>Покупатель</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($leads as $lead)
                                                <tr>
                                                    <td>{{ $lead->id }}</td>
                                                    <td>
                                                        @if($lead->way == 1)
                                                            Банкротство
                                                        @elseif($lead->way == 2)
                                                            Кредитование
                                                        @endif
                                                    </td>
                                                    <td>{{ $lead->fullname }}</td>
                                                    <td>{{ $lead->sum }}</td>
                                                    <td>
                                                        <?php
                                                        $region = \App\Models\Regions::
                                                        join('cities','regions.id','=','cities.id_region')->
                                                        where('cities.id',$lead->city)->
                                                        select('regions.name')->first();
                                                        echo $region->name;
                                                        ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                    $city_show = \App\Models\Cities::join('leads','cities.id','=','leads.city')
                                                        ->where('leads.id',$lead->id)
                                                        ->select('cities.name')
                                                        ->get();
                                                    foreach ($city_show as $f)
                                                        {
                                                            echo $f->name.'<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    {{--<td>{{ $lead['region'] }}</td>
                                                    <td>{{ $lead['city'] }}</td>--}}
                                                    @if($role!=1) <td>{{ $lead->telephone }}</td> @endif
                                                    <td>{{ $lead->comment }}</td>
                                                    <td>{{ $lead->created_at }}</td>
                                                    <td>{{ $lead->id_manager }}</td>
                                                    <td>{{ $lead->id_partner }}</td>
                                                    <td align="center">
                                                        <span id="adopted{{$lead->id}}">
                                                        @if($lead->adopted==0 && $role!=1 && $role!=2)
                                                            <button title="Принять" name="{{$lead->id}}" id="{{$lead->id}}"  onclick="LidLook(this)" style="font-size:10px;">Принять</button>
                                                        @endif
                                                            @if($lead->adopted==1 && $role!=1 && $role!=2)
                                                                <i class="fa fa-check" aria-hidden="true" style="color: forestgreen" title="Принят"></i>
                                                            @endif
                                                            </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{ $leads->links('simple_paginate') }}
                                    </div>
                                </div>
                            </div>
                    @else

                    @endif
                </div>
            </section>
        </div>
        <script>
            function json() {
                Json = {
                    query: function (url, param, json, cb) {
                        if (json) var json = 'json';
                        else var json = false;

                        if (url) var uri = url;
                        else var uri = 'window.location.pathname';
                        $.ajax({
                            type: 'POST',
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: uri,
                            data: param,
                            async: true,
                            dataType: json,
                            success: function (data) {
                                cb(data);
                            },
                            error: function (data) {
                            }
                        });
                    }
                };
            }
            function LidLook(obj) {
                json();
                Json.query('/orders/switch', 'switch=lid_adopted&&id=' + obj.id, false, function (data) {
                    $("#adopted"+obj.id).html('<i class="fa fa-check" aria-hidden="true" style="color: forestgreen" title="Принят"></i>');
                });
            }
        </script>
{!! $footer !!}
