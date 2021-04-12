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
                            <div class="card-header">
                                <h6 class="text-uppercase mb-0">Пользователи</h6>
                            </div>
                            <div class="card-body">
                                <table class="table card-text">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Логин</th>
                                        <th>Почта</th>
                                        <th>Роль</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($users))
                                        @foreach($users as $user)
                                            <tr>
                                                <th scope="row">{{ $user->id }}</th>
                                                <td>{{ $user->login }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role_name }}</td>
                                                <td>
                                                    <a href="{{ route('user_edit', $user->id) }}">
                                                        <i class="fas fa-user-edit"></i>
                                                    </a>
                                                </td>
                                                <td class="text-danger">
                                                    <form action="{{ route('user_remove', $user->id) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary-outline bg-transparent p-0">
                                                            <i class="far fa-trash-alt text-danger"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
{!! $footer !!}
