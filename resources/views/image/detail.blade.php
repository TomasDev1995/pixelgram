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
                        <?php $user_like = false; ?>
                        @foreach($image->like as $like)
                            @if($like->user->id == Auth::user()->id)
                                <?php $user_like = true; ?>
                            @endif
                        @endforeach

                        @if($user_like)
                            <img src="{{asset('/img/corazon-rojo.png')}}" data-id="{{$image->id}}" class="btn-dislike"/>
                        @else
                            <img src="{{asset('/img/corazon-negro.png')}}" data-id="{{$image->id}}" class="btn-like"/>
                        @endif
                        <span class="number_likes">{{count($image->like)}}</span>
                    </div>

                    <div class="clearfix"></div>
                    <div class="comments">
                        <h4>Comentarios ({{count($image->comments)}})</h4>
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
                        @foreach($image->comments as $comment)
                            <div class="comment">
                                <span class="nickname">{{'@'.$comment->user->nick}}</span>
                                <span class="nickname date">{{' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                                <p>{{$comment->content}}</p>

                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->images->user_id == Auth::user()->id))
                                    <a href="{{route('comment.delete', ['id' => $comment->id])}}" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </a>
                                @endif

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
