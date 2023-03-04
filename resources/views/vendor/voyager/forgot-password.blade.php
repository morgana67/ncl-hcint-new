@extends('voyager::auth.master')

@section('content')
    <div class="login-container">

        <p>Forgot Password</p>

        <form action="{{ route('admin.forgot-password.post') }}" method="POST">
            {{ csrf_field() }}
            <div class="alert alert-info">This page is for Administrators only to recover their accounts. If you are a Customer or Doctor <a href="{{url('/password/reset')}}" style="text-decoration: underline">click here</a> to recover your password</div>
            <div class="form-group form-group-default" id="emailGroup">
                <label>{{ __('voyager::generic.email') }}</label>
                <div class="controls">
                    <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                </div>
            </div>
            <div style="display: flex;justify-content: flex-start;align-items: center;">
            <button type="submit" class="btn btn-block login-button">
                <span class="signingin hidden"><span class="voyager-refresh"></span> Submitting...</span>
                <span class="signin">Submit</span>
            </button>
            <a href="{{route('voyager.login')}}" style="color: red; margin-left: 1rem">Cancel</a>

            </div>
        </form>

        <div style="clear:both"></div>

        @if(!$errors->isEmpty())
            <div class="alert alert-red">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div> <!-- .login-container -->
@endsection

@section('post_js')

    <script>
        var btn = document.querySelector('button[type="submit"]');
        var form = document.forms[0];
        var email = document.querySelector('[name="email"]');
        btn.addEventListener('click', function(ev){
            if (form.checkValidity()) {
                btn.querySelector('.signingin').className = 'signingin';
                btn.querySelector('.signin').className = 'signin hidden';
            } else {
                ev.preventDefault();
            }
        });
        email.focus();
        document.getElementById('emailGroup').classList.add("focused");

        // Focus events for email and password fields
        email.addEventListener('focusin', function(e){
            document.getElementById('emailGroup').classList.add("focused");
        });
        email.addEventListener('focusout', function(e){
            document.getElementById('emailGroup').classList.remove("focused");
        });

    </script>
@endsection
