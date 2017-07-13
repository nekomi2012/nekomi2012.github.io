@extends('admin.layout')

@section('content')

<div class="navbar navbar-inverse" id="nav" style="display: block;">

    <!-- Main Navigation: Inner -->
    <div class="navbar-inner">

        <form class="navbar-search pull-right" action="/admin/searchusers">
            <input type="text" name="name" class="search-query" placeholder="Поиск login" autocomplete="off">
        </form>
        <form class="navbar-search pull-right" action="/admin/searchusersname">
            <input type="text" name="name" class="search-query" placeholder="Поиск name" autocomplete="off">
        </form>

    </div>
    <!-- / Main Navigation: Inner -->

</div>

<style>td {
        white-space: nowrap;
        word-wrap: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }</style>


<div class="top-bar">
    <h3>Пользователи</h3>

</div>


<div class="well no-padding">


    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Ник</th>
            <th>Login</th>
            <th>Баланс</th>
            <th>Админ</th>
            <th>Youtuber</th>
        </tr>
        </thead>
        <tbody>


        @foreach($users as $i)


        <tr>
            <td>{{$i->id}}</td>
            <td>{{$i->username}}</td>
            <td>{{$i->login}}</td>
            <td>{{$i->money}}</td>
            <td>@if($i->is_admin)<span class="label label-important">Да</span>@else <span class="label label-success">Нет</span>
                @endif
            </td>
            <td>@if($i->is_yt)<span class="label label-important">Да</span>@else <span class="label label-success">Нет</span>
                @endif
            </td>
            <td><a href="/admin/givemoney/{{$i->id}}" class="btn btn-info">Перевести деньги</a></td>
            <td><a href="/admin/user/{{$i->id}}">Редактировать</a></td>
        </tr>
        @endforeach


        </tbody>
    </table>


    {{$users->render()}}
    <!-- / Add News: WYSIWYG Edior -->

</div>
<!-- / Add News: Content -->


</div>

</div>


@endsection
