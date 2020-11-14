@if(Auth::id() !=$user->id)
    @if()
    {{--お気に入り解除ボタンを表示--}}
    @else
    {{--お気に入り登録ボタンを表示--}}
    @endif
@endif