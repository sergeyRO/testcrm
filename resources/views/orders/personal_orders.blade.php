{!! $header !!}
<div class="d-flex align-items-stretch">
    {!! $sidebar !!}
    @include('orders.admin.modalUp')
    <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
            <section class="py-5">
                <div class="row">
                    <div class="col-lg-12">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-uppercase mb-0">Мои заказы</h6>
                                <a href="{{ route('personal_add_order') }}" class="btn btn-outline-success">Добавить заказ</a>
                            </div>


                            <form action="" method="GET" style="margin-left: 0%;">
                                <div id="search" style="margin-left: 30px">
                                    <br>
                                    <table>
                                        <tr><td><label for="sRegion">Регион</label></td>
                                            <td><select name="sRegion" id="sRegion" class="selectpicker" data-live-search="true" data-style="btn-secondary" data-none-Selected-Text="Выберите регион">
                                                    <option value="0" {{($sRegion==0) ? 'selected' : ''}}></option>
                                                    <?php
                                                    $region = \App\Models\Regions::get();
                                                    ?>
                                                    @foreach($region as $region)
                                                        <option value="{{$region->id}}" {{($region->id == $sRegion) ? 'selected' : ''}}>{{$region->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td></tr>
                                        <tr><td colspan="2"><br></td></tr>
                                        <tr><td><label for="sCity">Город</label></td>
                                            <td><select name="sCity" id="sCity" class="selectpicker" data-live-search="true" data-style="btn-secondary" data-none-Selected-Text="Выберите город">
                                                    <option value="0" {{($sCity==0) ? 'selected' : ''}}></option>
                                                    <?php
                                                    $city = \App\Models\Cities::get();
                                                    ?>
                                                    @foreach($city as $city)
                                                        <option value="{{$city->id}}" {{($city->id == $sCity) ? 'selected' : ''}}>{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td></tr>
                                        <tr><td colspan="2"><br></td></tr>
                                        <tr><td><label for="sWay">Направление</label></td>
                                            <td><select name="sWay" id="sWay" class="form-control rounded" style="font-size: 12px">
                                                    {{--@if($ent == $entity->entities_id) selected @endif--}}
                                                    <option value="1000"{{($way == 1000 || $way=='') ? 'selected' : ''}}>Выбрать все</option>
                                                    <option value="1" {{($way == 1) ? 'selected' : ''}}>Банкротство</option>
                                                    <option value="2" {{($way == 2) ? 'selected' : ''}}>Кредитование</option>
                                                </select>
                                            </td></tr>
                                        <tr><td colspan="2"><br></td></tr>
                                        <tr><td><label for="sStatus">Статус</label></td>
                                            <td><select name="sStatus" id="sStatus" class="form-control rounded" style="font-size: 12px">
                                                    <option value="1000"{{($stat == 1000 || $stat=='') ? 'selected' : ''}}>Выбрать все</option>
                                                    <?php
                                                    $st = \App\Models\StatusOrder::get();
                                                    foreach ($st as $sta)
                                                    {
                                                        if($sta->id == $stat)
                                                        {
                                                            echo '<option value="'.$sta->id.'" selected>'.$sta->name.'</option>';
                                                        }
                                                        else
                                                        {
                                                            echo '<option value="'.$sta->id.'">'.$sta->name.'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select></td></tr>
                                        <tr><td colspan="2"><br></td></tr>
                                        <tr><td><label for="sSum">Сумма</label></td>
                                            <td>
                                                <select name="sSum" class="form-control" id="sSum" >
                                                    <option value="100" {{($s == 100 || $s=='') ? 'selected' : ''}}>Выбрать все</option>
                                                    <option value="0" {{($s == 0 && $s!='') ? 'selected' : ''}}>от 50000 до 299999</option>
                                                    <option value="1" {{($s == 1 && $s!='') ? 'selected' : ''}}>от 300000 и выше</option>
                                                </select></td></tr>
                                        <tr><td colspan="2"><br></td></tr>
                                        <tr><td colspan="2">

                                        <tr><td><label for="dataCreate">Дата создания</label></td>
                                            <td>
                                                <input type="date" id="dataCreate" name="dataCreate" value="{{$dataCreate}}"/>
                                            </td></tr>
                                        <tr><td colspan="2"><br></td></tr>
                                        <tr><td colspan="2">

                                        <tr><td><label for="dataUp">Дата обновления</label></td>
                                            <td>
                                                <input type="date" id="dataUp" name="dataUp" value="{{$dataUp}}"/>
                                            </td></tr>
                                        <tr><td colspan="2"><br></td></tr>
                                        <tr><td colspan="2">
                                                <input type="submit" class="btn btn-primary" value="Применить">
                                                <input type="submit" class="btn btn-primary" name="filter_clear" value="Сбросить">
                                            </td></tr>
                                    </table>
                                </div>

                            </form>


                            <div class="card-body" style="font-size: 12px">
                                <table class="table card-text text-center" style="font: 12px;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Дата создания</th>
                                        <th>Дата обновления</th>
                                        <th>Статус</th>
                                        <th>Заявок всего / отгружено</th>
                                        <th>Направление</th>
                                        <th>Регион(ы)</th>
                                        <th>Город(а)</th>
                                        <th>Сумма</th>
                                        <th>Просмотр лидов</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($orders))
                                            @foreach($orders as $order)
                                                <?php
                                                $count_lid = \App\Models\LeadModel::where('order_id', $order->id)->count();
                                                ?>
                                                <?php
                                                        $status = \App\Models\StatusOrder::where('id',$order->status)->first();
                                                        ?>
                                                <tr
                                                        style ="
 <?php
                                                        switch($status->id)
                                                        {
                                                            case 1:
                                                                echo "background-color: #61B4CF";
                                                                break;
                                                            case 0:
                                                                echo "background-color: #FFE773";
                                                                break;
                                                            case 2:
                                                                echo "background-color: #62D99C";
                                                                break;
                                                        }
                                                        ?>
                                                                ">
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{$order->created_at}}</td>
                                                    <td>{{ $order->last_update }}</td>
                                                    <td>{{ $status->name }}</td>
                                                    <td>{{ $order->quantity }} / {{$count_lid}}{{--{{ $order->count_lead }}--}}</td>
                                                    <td>
                                                        @if($order->way == 1)
                                                            Банкротство
                                                        @else
                                                            Кредитование
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $region = \App\Models\Regions::
                                                        join('cities','regions.id','=','cities.id_region')->
                                                        join('order_city','order_city.id_city','=','cities.id')->
                                                        where('order_city.id_order',$order->id)->distinct('regions.id')->
                                                        select('regions.name')->get();
                                                        $k=0;
                                                        echo '<div id="LR'.$order->id.'">';
                                                        foreach ($region as $reg)
                                                        {
                                                            if($k<3)
                                                            {
                                                                echo $reg->name.'<br>';
                                                            }
                                                            else break;
                                                            $k++;
                                                        }
                                                        echo '</div>';
                                                        if(count($region)>3)
                                                        {
                                                            echo '<button title="Раскрыть список" class="ListRegion'.$order->id.'" name="ListRegion" id="'.$order->id.'"  onclick="ListRegion(this)" style="font-size:10px">Раскрыть</button>';
                                                            echo '<button title="Скрыть список" class="ListRegionNon'.$order->id.'" name="ListRegionNon" id="'.$order->id.'"  onclick="ListRegionNon(this)" style="font-size:10px;display:none">Скрыть</button>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $cityOrd =  \App\Models\OrderCity::join('cities','order_city.id_city','=','cities.id')
                                                            ->join('orders','order_city.id_order','=','orders.id')->
                                                            where('id_order',$order->id)->select('cities.name as name')->get();
                                                        $i=0;
                                                        echo '<div id="LC'.$order->id.'">';
                                                        foreach ($cityOrd as $f)
                                                        {
                                                            if($i<3)
                                                            {
                                                                echo $f->name.'<br>';
                                                            }
                                                            else break;
                                                            $i++;
                                                        }
                                                        echo '</div>';
                                                        if(count($cityOrd)>3)
                                                        {
                                                            echo '<button title="Раскрыть список" class="ListCity'.$order->id.'" name="ListCity" id="'.$order->id.'"  onclick="ListCity(this)" style="font-size:10px">Раскрыть</button>';
                                                            echo '<button title="Скрыть список" class="ListCityNon'.$order->id.'" name="ListCityNon" id="'.$order->id.'"  onclick="ListCityNon(this)" style="font-size:10px;display:none">Скрыть</button>';

                                                        }
                                                        ?>

                                                        {{--{{ $order->regions }}--}}</td>
                                                    {{--<td>{{ $order->sum }}</td>--}}
                                                    <td>
                                                        @if ($order->sum == 0)
                                                            от 50000 до 299999
                                                        @endif
                                                        @if ($order->sum == 1)
                                                            от 300000 и выше
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('personal_orders_leads', $order->id) }}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                    </td>
                                                        <td>
                                                            <button class='btn btn-warning btn-xs'  data-toggle="modal" data-target="#order_modal_update" title='Редактировать' name='{{$order->id}}' id='{{$order->id}}' onclick="updateOrderInf(this)">
                                                                <i class="fas fa-edit"></i></button>
                                                        </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{ $orders->appends(['sRegion' => $sRegion,'sCity' => $sCity,'sWay' => $way, 'sStatus' => $stat,'sSum' =>$s, 'dataCreate' => $dataCreate, 'dataUp' => $dataUp])->links('simple_paginate') }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div id="addLeadSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title"><span id="addLeadSuccessOrder"></span></h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" role="alert">
                            <span id="LeadSuccessOrder"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
{!! $footer !!}

        <script>
            function ListRegion(obj) {
                json();
                Json.query('/orders/switch', 'switch=all_region&&id=' + obj.id+'&&list=1', false, function (data) {
                    $("#LR"+obj.id).html(data);
                    $(".ListRegion"+obj.id).hide();
                    $(".ListRegionNon"+obj.id).show();
                });
            }

            function ListRegionNon(obj) {
                json();
                Json.query('/orders/switch', 'switch=all_region&&id=' + obj.id+'&&list=0', false, function (data) {
                    $("#LR"+obj.id).html(data);
                    $(".ListRegionNon"+obj.id).hide();
                    $(".ListRegion"+obj.id).show();
                });
            }

            function ListCity(obj) {
                json();
                Json.query('/orders/switch', 'switch=all_city&&id=' + obj.id+'&&list=1', false, function (data) {
                    $("#LC"+obj.id).html(data);
                    $(".ListCity"+obj.id).hide();
                    $(".ListCityNon"+obj.id).show();
                });
            }
            function ListCityNon(obj) {
                json();
                Json.query('/orders/switch', 'switch=all_city&&id=' + obj.id+'&&list=0', false, function (data) {
                    $("#LC"+obj.id).html(data);
                    $(".ListCityNon"+obj.id).hide();
                    $(".ListCity"+obj.id).show();
                });
            }


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

            $('#upOrder').on('click', function () {
                var id=$( "#ordNUM1" ).attr("alt");
                var limit_lid = $("#limit_lid").val();
                json();
                Json.query('/orders/switch', 'switch=updateOrderLimitLid&&id=' + idOrd + '&&limit_lid=' + limit_lid, false, function (data) {
                    if(data!='error')
                    {
                        $('#order_modal_update').modal('hide');
                        $('#addLeadSuccessOrder').text('Обновление заказа № '+idOrd);
                        $('#LeadSuccessOrder').text('Заказ обновлен успешно!');
                        $("#addLeadSuccess").modal('show');
                    }
                    else {
                        alert("Заполните все поля!");
                    }
                });
            })

            function updateOrderInf(obj) {
                window.idOrd=obj.id;
                document.getElementById("numOrd1").textContent=obj.id;
                $("#ordNUM1").attr( "alt",obj.id);
                json();
                Json.query('/orders/switch', 'switch=updateOrderInf&&id=' +  idOrd, false, function (data) {
                    var res = $.parseJSON(data);
                    document.getElementById('limit_lid').value=res.limit_lid;
                });
            }
        </script>
