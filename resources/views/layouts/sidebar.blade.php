@include('search.css')
@include('search.js')
<div id="sidebar" class="sidebar py-3">
    <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">Основное</div>
    <ul class="sidebar-menu list-unstyled">
        <li>@include('search.index')</li>
        <li class="sidebar-list-item"><a href="{{ route('dashboard') }}" class="sidebar-link text-muted"><i class="o-home-1 mr-3 text-gray"></i><span>Главная</span></a></li>
        {{--<li class="sidebar-list-item"><a href="charts.html" class="sidebar-link text-muted"><i class="o-sales-up-1 mr-3 text-gray"></i><span>Графики</span></a></li>--}}
            <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#pages" aria-expanded="false" aria-controls="pages" class="sidebar-link text-muted"><i class="o-wireframe-1 mr-3 text-gray"></i><span>Управление</span></a>
                <div id="pages" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        @if($user->role == 0)
                            <li class="sidebar-list-item">
                                <a href="{{ route('personal_orders') }}" class="sidebar-link text-muted pl-lg-5">Мои заказы</a>
                            </li>
                        @endif
                        @if($user->role > 0)
                            <li class="sidebar-list-item"><a href="{{ route('orders') }}" class="sidebar-link text-muted pl-lg-5">Заказы</a></li>
                            <li class="sidebar-list-item"><a href="{{ route('leads') }}" class="sidebar-link text-muted pl-lg-5">Лиды</a></li>
                        @endif
                        @if($user->role > 1)
                            <li class="sidebar-list-item"><a href="{{ route('users') }}" class="sidebar-link text-muted pl-lg-5">Пользователи</a></li>
                        @endif
                    </ul>
                </div>
            </li>
        {{--<li class="sidebar-list-item"><a href="tables.html" class="sidebar-link text-muted"><i class="o-table-content-1 mr-3 text-gray"></i><span>Таблицы</span></a></li>
        <li class="sidebar-list-item"><a href="forms.html" class="sidebar-link text-muted"><i class="o-survey-1 mr-3 text-gray"></i><span>Формы</span></a></li>--}}
        {{--<li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#pages" aria-expanded="false" aria-controls="pages" class="sidebar-link text-muted"><i class="o-wireframe-1 mr-3 text-gray"></i><span>Dropdown</span></a>
            <div id="pages" class="collapse">
                <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                    <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5">Page one</a></li>
                    <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5">Page two</a></li>
                    <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5">Page three</a></li>
                    <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted pl-lg-5">Page four</a></li>
                </ul>
            </div>
        </li>--}}
{{--        <li class="sidebar-list-item"><a href="login.html" class="sidebar-link text-muted"><i class="o-exit-1 mr-3 text-gray"></i><span>Login</span></a></li>--}}
    </ul>
{{--    <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">EXTRAS</div>--}}
    {{--<ul class="sidebar-menu list-unstyled">
        <li class="sidebar-list-item"><a href="#" class="sidebar-link text-muted"><i class="o-database-1 mr-3 text-gray"></i><span>Demo</span></a></li>
    </ul>--}}
</div>
