@extends('admin.layout')

@section('content')



        <div class="top-bar">
            <h3>Последние запросы на вывод</h3>

        </div>



        <div class="well no-padding">


            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Пользователь</th>
                    <th>Выводит</th>
                    <th>Кошелек</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($a as $b)
                    <tr>
                        <td>{{$b->id}}</td>
                        <td><a href="/profile/{{$b->name_id}}">{{$b->name}}</a></td>
                        <td>{{$b->amount}}</td>
                        <td>{{$b->nomer}}</td>
                        <td><a href="/admin/vivodclose/{{$b->id}}">Нажми чтобы закрыть</a></td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
            <!-- / Add News: WYSIWYG Edior -->

        </div>
        <!-- / Add News: Content -->




        </div>

        </div>
@endsection
