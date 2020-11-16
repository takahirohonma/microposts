@if (Auth::id() != $user->id)

    @if (Auth::user()->is_favorite($micropost->id))

        {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('いいね！を外す', ['class' => "button btn btn-warning"]) !!}
        {!! Form::close() !!}

    @else

        {!! Form::open(['route' => ['favorites.favorite', $micropost->id]]) !!}
            {!! Form::submit('いいね！を付ける', ['class' => "button btn btn-success"]) !!}
        {!! Form::close() !!}

    @endif

@endif