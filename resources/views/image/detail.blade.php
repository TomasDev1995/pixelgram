@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message')
            <div class="card pub_image pub_image_detail">
                <div class="card-header">
                    @if($image->user->image)
                    <div class="container-avatar">
                        <img src="{{route('user.avatar', ['filename' => $image->user->image])}}" class="avatar">
                    </div>
                    @endif
                    <div class="data-user">
                            {{$image->user->name.' '.$image->user->surname}}
                            <span class="nickname">
                                {{' | @'.$image->user->nick}}
                            </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="image-container">
                        <img src="{{ route('image.file', ['filename' => $image->imagen_path]) }}" alt=""/>
                    </div>
                    
                    <div class="description">
                        <span class="nickname">{{'@'.$image->user->nick}}</span> 
                        <span class="nickname date">{{' | '.\FormatTime::LongTimeFilter($image->created_at)}}</span>
                        <p>{{$image->description}}</p>
                    </div>

                    <div class="likes">
                        <img src="{{asset('/img/corazon-negro.png')}}" alt=""/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="comments">
                        <h3>Comentarios ({{count($image->comments)}})</h3>
                        <hr>

                        <form action="{{route('comment.save')}}" method="POST">
                            @csrf 
                            <input type="hidden" name="image_id" value="{{$image->id}}">
                            <p>
                                <textarea name="content"  id="" cols="30" rows="10" class="form-control box-comment {{$errors->has('content') ? 'is-invalid' : ''}}"></textarea>
                                @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                            
                            
                            <button type="submit" class="btn btn-success">
                                Enviar
                            </button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
