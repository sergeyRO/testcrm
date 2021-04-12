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
                                <h3 class="h6 text-uppercase mb-0">ПОИСК</h3>
                            </div>
                            <div class="card-body">





                                    <div class="col-1-6">
                                        <div class="abz">
                                            <style>
                                                form {
                                                    position: relative;
                                                    width: 300px;
                                                    margin: 0 auto;
                                                }
                                                .formwrapper1 {
                                                    position: relative;
                                                    width: 100%;
                                                    margin: 0 auto;
                                                }
                                                .find1 {

                                                    background: #F9F0DA;
                                                    width: 100%;
                                                    margin-top: 0.5em;}

                                                .find1 form {
                                                    background: #A3D0C3;
                                                }
                                                .find1 input {
                                                    width: 99%;
                                                    height: 39px;
                                                }
                                                .find1 button {
                                                    height: 42px;
                                                    width: 42px;
                                                    position: absolute;
                                                    top: 0;
                                                    right: 0;
                                                    cursor: pointer;
                                                }
                                                .find1 button:before {
                                                    content: "\f002";
                                                    font-family: FontAwesome;
                                                    font-size: 16px;
                                                    color: green;
                                                }

                                            </style>
                                            <div class="find1" id="find1">
                                                <div class="formwrapper1">
                                                    <input type="search1" id="search1" placeholder="Поиск" class="input"  name="search1" required>
                                                    <button type="submit1" onclick="find()"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="abz">
                                            <h2>Результаты поиска сайта по запросу "{{$find}}"</h2>
                                            <?php
                                            $result='';
                                            $user = \Illuminate\Support\Facades\Auth::user();
                                            if($user->role>0)
                                                {
                                                    $region_lid = \App\Models\Regions::
                                                    join('cities','regions.id','=','cities.id_region')
                                                        ->join('leads','cities.id','=','leads.city')
                                                        ->join('status_lids','leads.id_status','=','status_lids.id')
                                                        ->where('regions.name','like','%'.$find.'%')
                                                        ->orWhere('cities.name','like','%'.$find.'%')
                                                        ->select('regions.name as regions','cities.name as city','leads.sum as sum','status_lids.name as status','leads.id as id')->get();
                                                    $count_region_lid = count($region_lid);

                                                    $region_order = \App\Models\Regions::
                                                    join('cities','regions.id','=','cities.id_region')
                                                        ->join('order_city','cities.id','=','order_city.id_city')
                                                        ->join('orders','order_city.id_order','=','orders.id')
                                                        ->where('regions.name','like','%'.$find.'%')
                                                        ->orWhere('cities.name','like','%'.$find.'%')
                                                        ->select('regions.name as regions','cities.name as city','orders.sum as sum','orders.id as id')->get();
                                                    $count_region_order = count($region_order);

                                                    if($count_region_lid!=0){
                                                        $result .= '<h2 style="margin-bottom: 0.5em;">В разделе Лиды:</h2>';
                                                        foreach ($region_lid as $reg_lid)
                                                        {
                                                            $result .= '<b>Id лида: </b>'.$reg_lid->id.'<b> Регион: </b>'.$reg_lid->regions.'<b> Город: </b>'.$reg_lid->city.'<b> Сумма: </b>'.$reg_lid->sum.'<b> Статус: </b>'.$reg_lid->status.'<br>';
                                                        }
                                                        $result .= "<hr style='margin: 5px auto;'>";
                                                    }

                                                    if($count_region_order!=0)
                                                    {
                                                        $result .= '<h2 style="margin-bottom: 0.5em;">В разделе Заказы:</h2>';
                                                        foreach ($region_order as $reg_ord)
                                                        {
                                                            if($reg_ord->sum == 0) $reg_ord->sum = 'от 50000 до 299999';
                                                            if($reg_ord->sum == 1) $reg_ord->sum = 'от 300000 и выше';
                                                            $result .= '<b>Id заказа: </b>'.$reg_ord->id.'<b> Регион: </b>'.$reg_ord->regions.'<b> Город: </b>'.$reg_ord->city.' <b> Сумма: </b>'.$reg_ord->sum.'<br>';
                                                        }
                                                        $result .= "<hr style='margin: 5px auto;'>";
                                                    }
                                                    if($count_region_lid==0 && $count_region_order==0)
                                                    {
                                                        $result .= '<h2 style="margin-bottom: 0.5em;">Поиск не дал результата.</h2>';
                                                        $result .= "<hr style='margin: 5px auto;'>";
                                                    }
                                                    echo $result;
                                                }
                                                else
                                                    {
                                                        $region_lid = \App\Models\Regions::
                                                        join('cities','regions.id','=','cities.id_region')
                                                            ->join('leads','cities.id','=','leads.city')
                                                            ->join('status_lids','leads.id_status','=','status_lids.id')
                                                            ->where(function ($query) use($find) {
                                                                $query->where('regions.name','like','%'.$find.'%')
                                                                    ->orWhere('cities.name','like','%'.$find.'%');
                                                            })

                                                            ->where('leads.id_partner',$user->id)
                                                            ->select('regions.name as regions','cities.name as city','leads.sum as sum','status_lids.name as status','leads.id as id')->get();
                                                        $count_region_lid = count($region_lid);

                                                        $region_order = \App\Models\Regions::
                                                        join('cities','regions.id','=','cities.id_region')
                                                            ->join('order_city','cities.id','=','order_city.id_city')
                                                            ->join('orders','order_city.id_order','=','orders.id')
                                                            ->where(function ($query) use($find) {
                                                                $query->where('regions.name','like','%'.$find.'%')
                                                                    ->orWhere('cities.name','like','%'.$find.'%');
                                                            })
                                                            ->where('orders.id_creator',$user->id)
                                                            ->select('regions.name as regions','cities.name as city','orders.sum as sum','orders.id as id')->get();
                                                        $count_region_order = count($region_order);

                                                        if($count_region_lid!=0){
                                                            $result .= '<h2 style="margin-bottom: 0.5em;">В разделе Лиды:</h2>';
                                                            foreach ($region_lid as $reg_lid)
                                                            {
                                                                $result .= '<b>Id лида: </b>'.$reg_lid->id.'<b> Регион: </b>'.$reg_lid->regions.'<b> Город: </b>'.$reg_lid->city.'<b> Сумма: </b>'.$reg_lid->sum.'<b> Статус: </b>'.$reg_lid->status.'<br>';
                                                            }
                                                            $result .= "<hr style='margin: 5px auto;'>";
                                                        }

                                                        if($count_region_order!=0)
                                                        {
                                                            $result .= '<h2 style="margin-bottom: 0.5em;">В разделе Заказы:</h2>';
                                                            foreach ($region_order as $reg_ord)
                                                            {
                                                                if($reg_ord->sum == 0) $reg_ord->sum = 'от 50000 до 299999';
                                                                if($reg_ord->sum == 1) $reg_ord->sum = 'от 300000 и выше';
                                                                $result .= '<b>Id заказа: </b>'.$reg_ord->id.'<b> Регион: </b>'.$reg_ord->regions.'<b> Город: </b>'.$reg_ord->city.' <b> Сумма: </b>'.$reg_ord->sum.'<br>';
                                                            }
                                                            $result .= "<hr style='margin: 5px auto;'>";
                                                        }
                                                        if($count_region_lid==0 && $count_region_order==0)
                                                        {
                                                            $result .= '<h2 style="margin-bottom: 0.5em;">Поиск не дал результата.</h2>';
                                                            $result .= "<hr style='margin: 5px auto;'>";
                                                        }
                                                        echo $result;
                                                    }
                                            ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
{!! $footer !!}
        @include('search.js')
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
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
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



            $(document).ready(function() {
                $('#search1').keydown(function(e) {
                    if(e.keyCode === 13) {
                        find($(this).val());
                    }
                });
            });
            function find(el) {
                var msg1 = document.getElementById('search1').value;
                if(msg1.length>=2)
                {
                    document.location.replace("/search/"+msg1);
                }
            }
        </script>