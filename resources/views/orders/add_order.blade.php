{!! $header !!}

<div class="d-flex align-items-stretch">
    {!! $sidebar !!}
    <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
            <section class="py-5">
                <div class="row">
                    <!-- Basic Form-->
                    <div class="col-lg-12 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="h6 text-uppercase mb-0">Добавление заказа</h3>
                            </div>
                            <div class="card-body">
                                {{--<form action="{{ route('personal_create_order') }}" method="post" id="form">
                                    @csrf--}}
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Направление</label>
                                        <div class="col-md-9 select mb-3">
                                            <select name="way" class="form-control rounded" id="way">
                                                <option value="1">Банкротство</option>
                                                <option value="2">Кредитование</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Кол-во лидов</label>
                                        <div class="col-md-9">
                                            <input type="text" name="leads" class="form-control" value="0" id="leads">
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Кол-во лидов в сутки</label>
                                        <div class="col-md-9">
                                            <input type="text" name="limit_lid" class="form-control" value="0" id="limit_lid">
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Регионы и города</label>
                                        <div class="col-md-9 select mb-3">

                                        <select id="region" class="selectpicker" data-style="btn-primary" data-live-search="true"
                                                multiple data-actions-box="true"
                                                data-none-Selected-Text="Выберите регион"
                                                data-select-all-text="<span style='color:black'><b>V</b> всё</span>"
                                        data-deselect-all-text="<span style='color:black'><b>X</b> Отмена</span>">
                                            <?php
                                                $reg=\App\Models\Regions::get();
                                                    ?>
                                            @foreach($reg as $reg)
                                                    <option value="{{$reg->id}}">{{$reg->name}}</option>
                                                @endforeach
                                        </select>

                                            <select id="city" name="city" class="selectpicker" data-style="btn-primary" data-live-search="true"
                                                    multiple data-actions-box="true"
                                                    data-none-Selected-Text="Выберите города"
                                                    data-select-all-text="<span style='color:black'><b>V</b> всё</span>"
                                                    data-deselect-all-text="<span style='color:black'><b>X</b> Отмена</span>">

                                            </select>

                                        </div>
                                    </div>

                      <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Сумма{{--Сумма от--}}</label>
                                        <div class="col-md-9 select mb-3">
                                            <select name="sum" class="form-control" id="sum" >
                                                <option value="0">от 50000 до 299999</option>
                                                <option value="1">от 300000 и выше</option>

                                                {{--<option value="0">от 100000 до 299999</option>
                                                <option value="1">от 300000 до 499999</option>
                                                <option value="2">от 500000 и выше</option>--}}
                                                {{--<option value="100000">100 000</option>
                                                <option value="300000">300 000</option>
                                                <option value="500000">500 000</option>--}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <button type="submit" onclick="btn_click()" class="btn btn-primary">Добавить заказ</button>
                                        </div>
                                    </div>
                                {{--</form>--}}
                            </div>
                        </div>
                    </div>
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

            $('#region').change(function () {
                    json();
                Json.query('/orders/switch', 'switch=RegionCity&&arrReg=' + $('#region').val(), false, function (data) {
                    var res = $.parseJSON(data);
                    $('#city').html('');
                    $('#city').append(res.html);
                    $('#city').selectpicker('refresh');
                });
            });

            function btn_click()
             {
             var way = $("#way").val();
             var leads = $("#leads").val();
             var limit_lid = $("#limit_lid").val();
             var city = $('#city').val();
             var sum = $("#sum").val();
             json();
             Json.query('/orders/switch', 'switch=addOrders&&way=' + way + '&&leads=' + leads + '&&limit_lid=' + limit_lid + '&&city=' + city + '&&sum=' + sum, false, function (data) {
            if(data=='error')
            {
                alert('Выберите город!');
            }
            else {
                location.replace('/personal/orders');
            }
             });
             }
        </script>

{!! $footer !!}

