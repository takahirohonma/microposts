    @if(Auth::user()->is_favorite($micropost->id))
    {{--お気に入り登録ボタンを表示--}}
    {!! Form::open(['route' => ['favorites.favorite', $micropost->id]]) !!}
        {!! Form::submit('Favorite', ['class' => "btn btn-primary"]) !!}
    {!! Form::close() !!}
    @else
    {{--お気に入り解除ボタンを表示--}}
    {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}
        {!! Form::submit('Unfavorite', ['class' => "btn btn-danger"]) !!}
    {!! Form::close() !!}
    @endif