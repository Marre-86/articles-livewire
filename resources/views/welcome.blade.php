@extends('layouts.main')
@section('content')

<div class="w-30">

    <p class="intro">Данное веб-приложение было выполнено <a href="https://www.linkedin.com/in/artem-pokhiliuk/">Артёмом Похилюком</a> в качестве тестового задания. Сделано полностью во фреймворке Laravel.</p>
    <p class="intro">Задание, в соответсвии с которым был выполнен проект, можно найти <a href="https://docs.google.com/document/d/1Odscti-TbxImlQo6qSe1UCfwenEk2u10ZmuXffOEkuQ/edit">здесь</a>.</p>
    <p class="intro">Два пользователя добавлены в систему по умолчанию:</p>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Email</th>
            <th>Пароль</th>
            <th>Роль</th>
        </tr>
        </thead>
        <tr>
            <td>Robb Jones</td>
            <td>a@a</td>
            <td>a</td>
            <td>Админ</td>
        </tr>
        <tr>
            <td>John Persimonn</td>
            <td>s@s</td>
            <td>s</td>
            <td>Юзер</td>
        </tr>
    </table>
    <p class="intro">Админ может добавлять новых пользователей и награждать их правами юзера или админа.</p>
    <p class="intro">Обычная регистрация создаёт пользователей с правами юзеров.</p>
    
</div>
@endsection