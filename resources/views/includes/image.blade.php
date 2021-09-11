<div class="card pub_image">
    <div class="card-header">
        @if($image->user->image)
            <div class="container-avatar">
                <img src="{{route('user.avatar', ['filename' => $image->user->image])}}" class="avatar">
            </div>
        @endif
        <div class="data-user">
            <a href="{{ route('image.detail', ['id' => $image->id]) }}">
                {{$image->user->name.' '.$image->user->surname}}
                <span class="nickname">
                    {{' | @'.$image->user->nick}}
                </span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="image-container">
            <a href="{{ route('image.detail', ['id' => $image->id]) }}">
                <img src="{{ route('image.file', ['filename' => $image->imagen_path]) }}" alt=""/>
            </a>
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

        <div class="comments">
            <a href="#" class="btn btn-warning btn-sm btn-comments">
                Comentarios ({{count($image->comments)}})
            </a>
        </div>

    </div>
</div>
