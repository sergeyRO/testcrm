
{{--<div class="col-1-6">
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
        $result = '';

        $region = DB::table('regions')->where('show_site',1)
            ->where('region', 'like', '%'.$find.'%')
            ->orderBy('region','ASC')
            ->get();
        $count_region = count($region);

        $city = DB::table('cities')
            ->join('regions','cities.region_id','=','regions.id')
            ->where('cities.show_site',1)
            ->where('regions.show_site',1)
            ->where('city', 'like', '%'.$find.'%')
            ->orderBy('cities.city','ASC')
            ->select('cities.code as code','cities.city as city','cities.subdomen as subdomen')
            ->get();
        $count_city = count($city);

        $smi = DB::table('smis')
            ->join('cities','smis.id_city','=','cities.id')
            ->join('regions','cities.region_id','=','regions.id')
            ->where('cities.show_site',1)
            ->where('regions.show_site',1)
            ->where('smis.show_site',1)->where('name', 'like', '%'.$find.'%')
            ->orderBy('smis.name','ASC')
            ->select('smis.code as code','smis.name as name','cities.code as cityCode','cities.subdomen as subdomen')
            ->get();
        $count_smi = count($smi);

        if($count_city!=0){
            $result .= '<h2 style="margin-bottom: 0.5em;">В разделе город:</h2>';
            foreach ($city as $city)
            {
                $result .= '
		<a href="'.$subdomain->subdomain($city->subdomen,$city->code,'gorod','','','').'">'.$city->city.'</a><br>';
            }
            $result .= "<hr style='margin: 5px auto;'>";
        }
        if($count_region!=0)
        {
            $result .= '<h2 style="margin-bottom: 0.5em;">В разделе регион:</h2>';
            foreach ($region as $region)
            {
                $result .= '
<a href="'.$subdomain->subdomain('','','region','','',$region->code).'">'.$region->region.'</a><br>';
            }
            $result .= "<hr style='margin: 5px auto;'>";
        }
        if($count_smi!=0) {
            $result .= '<h2 style="margin-bottom: 0.5em;">В разделе СМИ:</h2>';
            foreach ($smi as $smi) {
                $result .= '
		<a href="'.$subdomain->subdomain($smi->subdomen,$smi->cityCode,'smi','',$smi->code,'').'">' . $smi->name . '</a><br>';
            }
            $result .= "<hr style='margin: 5px auto;'>";
        }
        if($count_city==0 && $count_region==0 && $count_smi==0)
        {
            $result .= '<h2 style="margin-bottom: 0.5em;">Поиск не дал результата.</h2>';
            $result .= "<hr style='margin: 5px auto;'>";
        }
        echo $result;
        ?>
    </div>
</div>--}}
<div class="find" id="find">
    <div class="formwrapper">
        <input type="search" id="search" placeholder="Поиск" class="input"  name="search" required>
        <button type="submit" onclick="search_btn()"></button>
        <div id="kabsearchform"></div>
    </div>
</div>