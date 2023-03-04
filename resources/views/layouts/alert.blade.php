@if(session()->has('message.level'))
    <div class="alert alert-{{session('message.level')}}">
        <ul>
            <li>{!! session('message.content') !!}</li>
        </ul>
    </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
