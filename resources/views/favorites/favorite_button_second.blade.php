
@if (Auth::user()->is_favorite($favorite->id))

        {!! Form::open(['route' => ['favorites.unfavorite', $favorite->id], 'method' => 'delete']) !!}
            {!! Form::submit('お気に入りを外す', ['class' => "button btn btn-warning"]) !!}
        {!! Form::close() !!}

@else

        {!! Form::open(['route' => ['favorites.favorite', $favorite->id]]) !!}
            {!! Form::submit('お気に入りを付ける', ['class' => "button btn btn-success"]) !!}
        {!! Form::close() !!}

@endif
    
    