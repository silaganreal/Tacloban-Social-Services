

<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <meta name="apple-mobile-web-app-title" content="Real Silagan">
    <title>Tacloban Social Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons'>
    <link rel="stylesheet" href="{{ asset('css/login2.css') }}">
    <script>
        window.console = window.console || function(t) {};

        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
    </script>
</head>

<body translate="no" >
    <div class="form">
        <div class="form-toggle"></div>
        <div class="form-panel one">
            <div class="form-header">
                <h1>Tacloban Social Services</h1>
            </div>
            <div class="form-content">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label>Username</label>
                        <!-- <input type="email" name="email" id="email" :value="old('email')" required autofocus/> -->
                        <input type="text" name="username" id="username" :value="old('username')" required autofocus/>
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required autocomplete="current-password"/>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <label class="form-remember">
                        <input type="checkbox" name="remember" id="remember_me" />Remember Me
                        &nbsp;&nbsp;
                        {{-- @if (Route::has('password.request'))
                            <a class="form-recovery" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif --}}
                    </div>
                    <div class="form-group">
                        <button type="submit">Log In</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- <div class="form-panel two">
            <div class="form-header">
            <h1>Register Account</h1>
            </div>
            <div class="form-content">
            <form>
                <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required="required"/>
                </div>
                <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required="required"/>
                </div>
                <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" id="cpassword" name="cpassword" required="required"/>
                </div>
                <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required="required"/>
                </div>
                <div class="form-group">
                <button type="submit">Register</button>
                </div>
            </form>
            </div>
        </div> --}}
    </div>

    <!-- <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script> -->
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    {{-- <script src='https://codepen.io/andytran/pen/vLmRVp.js'></script> --}}
    {{-- <script id="rendered-js" >
        $(document).ready(function () {
        var panelOne = $('.form-panel.two').height(),
        panelTwo = $('.form-panel.two')[0].scrollHeight;

        $('.form-panel.two').not('.form-panel.two.active').on('click', function (e) {
            e.preventDefault();

            $('.form-toggle').addClass('visible');
            $('.form-panel.one').addClass('hidden');
            $('.form-panel.two').addClass('active');
            $('.form').animate({
            'height': panelTwo },
            200);
        });

        $('.form-toggle').on('click', function (e) {
            e.preventDefault();
            $(this).removeClass('visible');
            $('.form-panel.one').removeClass('hidden');
            $('.form-panel.two').removeClass('active');
            $('.form').animate({
            'height': panelOne },
            200);
        });
        });
    </script> --}}

</body>

</html>

