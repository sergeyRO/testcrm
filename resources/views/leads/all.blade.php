{!! $header !!}
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
                                <h6 class="text-uppercase mb-0">Лиды</h6>
                                <button type="button" data-toggle="modal" data-target="#order_modal"{{--"#addLeadModal"--}} onclick="btn_lid(this)" class="btn btn-outline-primary py-0">Добавить лид</button>
                            </div>
{{--<button onclick="bitrix()">Bitrix24</button>--}}

<form action="" method="GET" style="margin-left: 0%;">
                            <div id="search" style="margin-left: 30px">
                                <br>
                                <table>
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
                                                $st = \App\Models\StatusLid::get();
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
                                    <tr><td><label for="dataCreate">Дата создания</label></td>
                                        <td>
                                            <input type="date" id="dataCreate" name="dataCreate" value="{{$dataCreate}}"/>
                                        </td></tr>
                                    <tr><td colspan="2"><br></td></tr>
                                    <tr><td><label for="sSum">Сумма</label></td>
                                        <td>
                                            <select name="sSum" class="form-control" id="sSum" >
                                                <option value="100" {{($s == 100 || $s=='') ? 'selected' : ''}}>Выбрать все</option>
                                                <option value="0" {{($s == 0 && $s!='') ? 'selected' : ''}}>от 50000 до 299999</option>
                                                <option value="1" {{($s == 1 && $s!='') ? 'selected' : ''}}>от 300000 и выше</option>
                                            </select>
                                            {{--<input name="sSum" id="sSum" type="number" class="form-control" style="font-size: 12px" value="{{$sum}}">--}}</td></tr>
                                    <tr><td colspan="2"><br></td></tr>
                                    <tr><td colspan="2">

                                            <input type="submit" class="btn btn-primary" value="Применить">
                                            <input type="submit" class="btn btn-primary" name="filter_clear" value="Сбросить">
                                        </td></tr>
                                </table>
                            </div>

                            </form>



                            <div class="card-body" style="font-size: 12px">
                                <table class="table card-text text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Направление</th>
                                        <th>Статус</th>
                                        <th>Id заказа</th>
                                        <th>ФИО</th>
                                        <th>Сумма</th>
                                        <th>Регион</th>
                                        <th>Город</th>
                                        @if($role>1)
                                        <th>Телефон</th>
                                        @endif
                                        <th>Комментарий</th>
                                        <th>Дата поступление</th>
                                        <th>Менеджер</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($leads))
                                        @foreach($leads as $lead)
                                            <tr style ="
 <?php
                                            switch($lead->id_status)
                                            {
                                                case 1:
                                                    echo "background-color: #61B4CF";
                                                    break;
                                                case 2:
                                                    echo "background-color: #FFE773";
                                                    break;
                                                case 3:
                                                    echo "background-color: #62D99C";
                                                    break;
                                                case 4:
                                                    echo "background-color: #FF7340";
                                                    break;
                                            }
                                            ?>
">
                                                <td>{{ $lead->id }}</td>
                                                <td>
                                                    {{($lead->way == 1) ? 'Банкротство' : 'Кредитование'}}
                                                </td>
                                                <td>
                                                    <?php
                                                        $status = \App\Models\StatusLid::where('id',$lead->id_status)->first();
                                                        echo $status->name;
                                                        ?>
                                                </td>
                                                <td>{{$lead->order_id}}</td>
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
                                               {{-- <td>{{ $lead->region }}</td>
                                                <td>{{ $lead->city }}</td>--}}
                                                @if($role>1)
                                                <td>{{ $lead->telephone }}</td>
                                                @endif
                                                <td>{{ $lead->comment }}</td>
                                                {{--<td>{{ $lead->receipt_date }}</td>--}}
                                                <td>{{$lead->created_at}}</td>
                                                <td>{{ $lead->id_manager }}</td>
                                                <td>

                                                </td>
                                                    <td>
                                                        <button class='btn btn-danger' onclick="delClick(this)" title='Удалить' name='{{$lead->id}}' id='{{$lead->id}}'>
                                                            <i class="fas fa-trash fa-2"></i></button>
                                                    </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{ $leads->appends(['sCity' => $sCity,'sWay' => $way, 'sStatus' => $stat,'sSum' =>$s, 'dataCreate' => $dataCreate])->links('simple_paginate') }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

@include('orders.admin.modal')
        <div id="addLeadSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Добавление лида</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" role="alert">
                            Вы успешно добавили лида
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Закрыть</button>
                    </div>
                </div>
            </div>
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

            var modal = document.getElementById("order_modal");

            function delClick(obj) {
                idLid=obj.id;
                var qDel = confirm('Вы точно желаете удалить Лид №'+idLid);
                if(qDel==true)
                {
                    json();
                    Json.query('/orders/switch', 'switch=del_lid&&id=' + idLid, false, function (data) {
                        document.location.reload();
                    });
                }
            }
            function btn_lid () {
                document.getElementById('fio').innerHTML="";
                document.getElementById('phone').innerHTML="";
                document.getElementById('comment').innerHTML="";
                document.getElementById('sum').innerHTML="";
                json();
                Json.query('/orders/switch', 'switch=regions', false, function (data) {
                    var res = $.parseJSON(data);
                    $('#region').html('');
                    $('#region').append(res.html);
                    $('#region').selectpicker('refresh');
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

            $('#addLead').on('click', function () {
                var way = $("#way").val();
                var fio = $("#fio").val();
                var phone = $("#phone").val();
                var comment = $("#comment").val();
                var city = $('#city').val();
                var sum = $("#sum").val();
                json();
                Json.query('/orders/switch', 'switch=addLidsNull&&way=' + way + '&&fio=' + fio + '&&comment=' + comment + '&&city=' + city + '&&sum=' + sum + '&&phone=' + phone, false, function (data) {
                  console.log(data);
                    if(data!='error')
                    {
                        $('#order_modal').modal('hide');
                        $('#addLeadSuccessOrder').text('Лид добавлен');
                        $("#addLeadSuccess").modal('show');
                    }
                    else {
                        alert("Заполните все поля!");
                    }
                });
            })

        </script>
{!! $footer !!}
