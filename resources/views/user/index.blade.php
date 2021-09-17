@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Amigos</h1>
            <form method="GET" action="{{route('user.index')}}" id="buscador">
                <div class="row">
                    <div class="form-group col">
                        <input type="text" id="search" class="form-control">
                    </div>
                    <div class="form-group col btn-search">
                        <input type="submit" value="Buscar" class="btn btn-success">
                    </div>
                </div>
            </form>  
            <hr/>
            @foreach($users as $user)
            <div class="profile-user">
                    @if($user->image)
                        <div class="container-avatar">
                            <img src="{{route('user.avatar', ['filename' => $user->image])}}" alt="">
                        </div>
                    @else
                        <div class="container-avatar">
                            <img src="{{asset('img/out-photo.png')}}" alt="">
                        </div>
                    @endif
                    <div class="user-info">
                        <h3>{{'@'.$user->nick}}</h3>
                        <h4>{{$user->name.' '.$user->surname}}</h4>
                        <p>{{' Se unió: '.\FormatTime::LongTimeFilter($user->created_at)}}</p>
                        <a href="{{route('user.profile',['id'=>$user->id])}}" class="btn btn-success">Perfil</a>
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                </div>
            @endforeach
             <!-- paginacion -->
            <div class="clearfix"></div>
            {{$users->links()}}
        </div>
    </div>
</div>
@endsection
