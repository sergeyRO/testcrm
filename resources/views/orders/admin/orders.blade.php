{!! $header !!}
@include('orders.admin.modal')
@include('orders.admin.modalUp')

<div class="d-flex align-items-stretch">
    {!! $sidebar !!}
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
                                <h6 class="text-uppercase mb-0">Заказы</h6>
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


                            <div class="card-body">
                                <table class="table card-text text-center" style="font-size: 12px;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Дата создания</th>
                                        <th>Дата обновления</th>
                                        <th>Заявок всего / отгружено</th>
                                        <th>Направление</th>
                                        <th>Регион(ы)</th>
                                        <th>Город(а)</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                        <th>Логин создателя</th>
                                        @if($role > 1)
                                            <th>Почта создателя</th>
                                        @endif
                                        <th>Посмотреть лиды заказа</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($orders))
                                        @foreach($orders as $order)
                                            <?php
                                                    $count_lid = \App\Models\LeadModel::where('order_id', $order->id)->count();
                                            ?>
                                            <tr
                                                    style ="
 <?php
                                                    switch($order->status)
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
                                                <td>
                                                    {{ $order->quantity }} / {{$count_lid}}
                                                   {{-- <div class="my-1"></div>
                                                    @if($order->status == 1)
                                                        <button type="button" id="{{$order->id}}" onclick="btn_lid(this)" data-toggle="modal" data-target="#order_modal" class="btn btn-outline-primary py-0">Добавить лид</button>
                                                    @endif--}}
                                                </td>
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
                                                <td>{{--{{ $order->regions }}--}}
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
                                                </td>
                                                <td>
                                                    @if ($order->sum == 0)
                                                        от 50000 до 299999
                                                    @endif
                                                    @if ($order->sum == 1)
                                                            от 300000 и выше
                                                    @endif

                                                    </td>
                                                <td>
                                                    @if($role > 1)
                                                        <div>
                                                            @if($order->status == 0)
                                                                <input id="option" name="status_order" type="checkbox" data-order="{{ $order->id }}">
                                                            @else
                                                                <input id="option" name="status_order" type="checkbox" checked data-order="{{ $order->id }}">
                                                            @endif
                                                        </div>
                                                    @else
                                                        @if($order->status == 0)
                                                            Не активный
                                                        @else
                                                            Активный
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{$order->login}}</td>
                                                @if($role > 1)
                                                    <td>{{$order->email}}</td>
                                                @endif
                                                <td>
                                                    @if($count_lid > 0)
                                                        <a href="{{ route('orders_leads', $order->id) }}">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                {{--@if($role > 1)
                                                    <td>
                                                        <button class='btn btn-danger' onclick="delClick(this)" title='Удалить' name='{{$order->id}}' id='{{$order->id}}'>
                                                            <i class="fas fa-trash fa-2"></i></button>
                                                    </td>
                                                @endif--}}
                                                @if($role > 1)
                                                    <td>
                                                    <button class='btn btn-warning btn-xs'  data-toggle="modal" data-target="#order_modal_update" title='Редактировать' name='{{$order->id}}' id='{{$order->id}}' onclick="updateOrderInf(this)">
                                                        <i class="fas fa-edit"></i></button>

                                                        <button class='btn btn-danger btn-xs' onclick="delClick(this)" title='Удалить' name='{{$order->id}}' id='{{$order->id}}'>
                                                            <i class="fa fa-trash"></i></button>
                                                    </td>
                                                    @endif
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
        @if($role > 1)
            @csrf
            <script>
                $('input[name="status_order"]').on('change', function () {
                    var result = $(this).prop('checked') ? 1 : 0;
                    var order = $(this).data('order');

                    $.ajax({
                        method: "post",
                        url: "{{ route('update_order_status_custom') }}",
                        data: {
                            '_token' : $('input[name="_token"]').val(),
                            'order': order,
                            'status': result
                        }
                    })
                })
            </script>
        @endif

        <script>
            $(document).ready(function() {
                window.reg_prov=0;
            });

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



            function delClick(obj) {
                idOrder=obj.id;
                var qDel = confirm('Вы точно желаете удалить Заказ №'+idOrder+'? ' +
                    'При удалении заказа все лиды связанные с заказом будут отвязана и переведены в статус: ' +
                    '"Не присвоен" - нет подходящего заказа с дата не превышает 15 дней с создания лида, ' +
                    '"Присвоен" - есть подходящий заказ с дата не превышает 15 дней с создания лида, ' +
                    'иначе лид перейдет в статус "Просрочен"');
                if(qDel==true)
                {
                    json();
                    Json.query('/orders/switch', 'switch=del_order&&id=' + idOrder, false, function (data) {
                        document.location.reload();
                    });
                }
            }

            var modal = document.getElementById("order_modal");

            $('#addLead').on('click', function () {
                var id=$( "#ordNUM" ).attr("alt");
                var way = $("#way").val();
                var fio = $("#fio").val();
                var phone = $("#phone").val();
                var comment = $("#comment").val();
                var city = $('#city').val();
                var sum = $("#sum").val();
                json();
                Json.query('/orders/switch', 'switch=addLids&&id=' + id + '&&way=' + way + '&&fio=' + fio + '&&comment=' + comment + '&&city=' + city + '&&sum=' + sum + '&&phone=' + phone, false, function (data) {
                    if(data!='error')
                   {
                       $('#order_modal').modal('hide');
                       $('#addLeadSuccessOrder').text('Добавление лида к заказу № '+id);
                       $('#LeadSuccessOrder').text('Лид добавлен успешно!');
                       $("#addLeadSuccess").modal('show');
                    }
                    else {
                        alert("Заполните все поля!");
                    }
                });
            })

            $('#upOrder').on('click', function () {
                var id=$( "#ordNUM1" ).attr("alt");
                var limit_lid = $("#limit_lid").val();
                var quantity = $("#quantity").val();
                var way = $("#way").val();
                var city = $('#city1').val();
                json();
                Json.query('/orders/switch', 'switch=updateOrder&&id=' + idOrd + '&&limit_lid=' + limit_lid + '&&city=' + city + '&&quantity=' + quantity + '&&way=' + way , false, function (data) {
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

            $('#region1').change(function () {
                var i=0;
                reg_prov++;
                $( "#region1 option:selected" ).each(function() {
                    i++;
                });
                if(i>0 && reg_prov==1)
                {
                }
                if(reg_prov>1) {
                    reg_prov++;
                    json();
                    Json.query('/orders/switch', 'switch=RegionCity&&arrReg=' + $('#region1').val(), false, function (data) {
                        var res = $.parseJSON(data);
                        $('#city1').html('');
                        $('#city1').append(res.html);
                        $('#city1').selectpicker('refresh');
                    });
                }
            });

            function updateOrderInf(obj) {
                reg_prov=0;
                window.idOrd=obj.id;
                document.getElementById("numOrd1").textContent=obj.id;
                $("#ordNUM1").attr( "alt",obj.id);
                json();
                Json.query('/orders/switch', 'switch=updateOrderInf&&id=' +  idOrd, false, function (data) {
                    var res = $.parseJSON(data);
                    document.getElementById('limit_lid').value=res.limit_lid;
                    $("#way [value='"+res.way+"']").attr("selected", "selected");
                    document.getElementById('quantity').value=res.quantity;

                    $('#region1').html('');
                    $('#region1').append(res.regionList);
                    $('#region1').selectpicker('refresh');
                    $('#region1').selectpicker('val', res.regSel);

                    $('#city1').html('');
                    $('#city1').append(res.cityList);
                    $('#city1').selectpicker('refresh');
                    $('#city1').selectpicker('val', res.citySel);
                });
            }

            $('#region').change(function () {
                json();
                Json.query('/orders/switch', 'switch=RegionCity&&arrReg=' + $('#region').val(), false, function (data) {
                    var res = $.parseJSON(data);
                    $('#city').html('');
                    $('#city').append(res.html);
                    $('#city').selectpicker('refresh');
                });
            });

            /*function btn_lid (obj) {
                window.id=obj.id;
                document.getElementById("numOrd").textContent=obj.id;
                document.getElementById('fio').innerHTML="";
                document.getElementById('phone').innerHTML="";
                document.getElementById('comment').innerHTML="";
                document.getElementById('sum').innerHTML="";
                $("#ordNUM").attr( "alt",obj.id);
                json();
                Json.query('/orders/switch', 'switch=regions', false, function (data) {
                    var res = $.parseJSON(data);
                    $('#region').html('');
                    $('#region').append(res.html);
                    $('#region').selectpicker('refresh');
                });
            }*/
        </script>

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