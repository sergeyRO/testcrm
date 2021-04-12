{!! $header !!}
<div class="d-flex align-items-stretch">
    {!! $sidebar !!}
    <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
            <section class="py-5">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                            @if(session('status_errors'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('status_errors') }}
                            </div>
                            @endif
                            @if(session('status_success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status_success') }}
                                </div>
                            @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0 d-flex justify-content-between align-items-center">
                                    <span class="h6 text-uppercase">
                                        Редактирование пользователя {{ $user[0]->login }}
                                    </span>
                                    <a href="{{ route('users') }}" class="btn btn-outline-primary">Вернуться назад</a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{ route('user_update', $user[0]->id) }}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Логин</label>
                                        <div class="col-md-9">
                                            <input type="text" name="login" class="form-control" value="{{ $user[0]->login }}">
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Почта</label>
                                        <div class="col-md-9">
                                            <input type="email" name="email" class="form-control" value="{{ $user[0]->email }}">
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Роль</label>
                                        <div class="col-md-9 select mb-3">
                                            <select name="role" class="form-control">
                                                <option value="0" @if($user[0]->role == 0) selected @endif>Пользователь</option>
                                                <option value="1" @if($user[0]->role == 1) selected @endif>Менеджер</option>
                                                <option value="2" @if($user[0]->role == 2) selected @endif>Администратор</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <a href="{{ route('users') }}" class="btn btn-secondary">Отменить</a>
                                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
{!! $footer !!}
