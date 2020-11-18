@if (Auth::user()->is_favorite($micropost->id))
        {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('お気に入りを外す', ['class' => "button btn btn-warning"]) !!}
        {!! Form::close() !!}
@else
        {!! Form::open(['route' => ['favorites.favorite', $micropost->id]]) !!}
            {!! Form::submit('お気に入りを付ける', ['class' => "button btn btn-success"]) !!}
        {!! Form::close() !!}
@endif