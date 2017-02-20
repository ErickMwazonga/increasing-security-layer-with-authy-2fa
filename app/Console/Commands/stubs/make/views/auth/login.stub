@extends('layouts.app')

@section('content')

    <div class="card login" style="display:">{{-- Card Login Form --}}
        <h1 class="title">Login 
            <span class="animated bounceIn error">Your credential was bad.</span>
        </h1>
        
        <div class="row">
            <form class="col s12" action="#" id="loginForm">

                {{ csrf_field() }}

                <div class="row">
                    <div class="input-field col s12">
                        <input type="email" name="email" value="{{ old('email') }}" class="validate">
                        <label for="email">Email</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" name="password" class="validate">
                        <label for="password">Password</label>
                    </div>
                </div>
                

                <div class="row">
                    <div class="input-field col s12" style="text-align:center">
                        <button type="submit" class="waves-effect waves-light btn" id="login" 
                        >GO</button>
                    </div>
                </div>

                <div class="row bottom">
                    <div class="input-field col s12">
                        <a href="/password/reset">Forgot your password?</a>
                        <a href="javascript:" class="toggle">Register</a>
                    </div>
                </div>
            </form>
        </div>
    </div>{{-- End Card Login Form --}}

    <div class="card register" style="display:none">{{-- Card Register Form --}}
        <h1 class="title">Register
            <span class="animated bounceIn error">Something went wrong.</span>
            <div class="close"></div>
        </h1>

        <div class="row">
            <form class="col s12" action="#" method="POST" id="registerForm">

                {{ csrf_field() }}

                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="name" class="validate">
                        <label for="name">Username</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input type="email" name="email" class="validate">
                        <label for="email">Email</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <select id="authy-countries">
                        </select>
                        <label>Country Code</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input type="tel" name="phone_number" class="validate">
                        <label>Phone Number</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" name="password" class="validate">
                        <label for="password">Password</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" name="password_confirmation" class="validate">
                        <label for="password">Confirm Password</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12" style="text-align:center">
                        <button class="waves-effect waves-light btn" id="register">REGISTER</button>
                    </div>
                </div>

            </form>
        </div>
    </div>{{-- End Card Register Form --}}

    <div id="modal1" class="modal">{{-- Card Modal Form --}}

        <div class="card token" style="display:">
            <h1 class="title">Please enter your Token 
                <span class="animated bounceIn error">Invalid token.</span>
            </h1>

            <div class="row">
                <form id="authySmsForm" action="#">
                    {{ csrf_field() }}

                    <div class='auth-ot'>
                        <i class="fa fa-spinner fa-pulse"></i> Waiting for OneTouch Approval ...
                    </div>

                    <div class='auth-token'>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="fa fa-mobile"></i> Authy OneTouch not available
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="authy-token" name="token" class="validate">
                                <label for="email">Authy Token</label>
                            </div>
                        </div>
                        
                        <a href="#!" class="modal-action modal-close waves-effect waves-light btn-flat">Cancel</a>
                        <button type="submit" class="waves-effect waves-light btn" id="authySms">Verify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>{{-- End Card Modal Form --}}
@endsection

@push('scripts')
<script>

    $(document).ready(function() {
        // Initialize Authy
        Authy.UI.ui = new Authy.UI();
        Authy.UI.ui.init();

        // Initialize Materialize
        $('select').material_select();
        
        $('.toggle').on('click', function() {
            $('.register').show().stop().addClass('animated bounceInDown')
            .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass('animated bounceInDown');
            });

            $('.card.login').stop().addClass('active');
            $('.pen-title h1').stop().addClass('active');
        });

        $('.close').on('click', function() {
            $('.register').stop().addClass('animated bounceOutDown')
            .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass('animated bounceOutDown').hide();
            });

            $('.card.login').stop().removeClass('active');
            $('.pen-title h1').stop().removeClass('active');
        });

        $('#login').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: '/login',
                type: 'POST',
                data: $('#loginForm').serialize(),
                success: (data) => {
                    var data = JSON.parse(data.replace(/1/g, ""));
                    
                    $('.login .error').hide();
                    $("#modal1").openModal({dismissible: false});

                    if (data.success) {
                        $('.auth-ot').fadeIn()
                        
                        checkForOneTouch();
                        
                    } else {
                        $('.auth-token').fadeIn()
                    }
                },
                error: (data) => {
                    $('.login .error').show();
                }
            });
        });

        var checkForOneTouch = function () {
            $.get( "/authy/status", function(data) {

                if (data.status == 'approved') {
                    window.location.href = "/home";
                } else if (data.status == 'denied') {
                    $('.auth-ot').fadeOut(function() {
                        $('.auth-token').fadeIn('slow')
                    })
                
                    $.get("/authy/send_token")

                } else {
                    setTimeout(checkForOneTouch, 2000);
                }
            });
        }

        $('#register').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: '/register',
                type: 'POST',
                data: $('#registerForm').serialize()+'&country_code='+$('#country-code-0').val(),
                success: (data) => {
                    $('.register .error').hide();
                    window.location.href = data;
                },
                error: (data) => {
                    $('.register .error').show();
                }
            });
        });

        $('#authySms').on('click', function (e) {
            e.preventDefault();
           
            $.ajax({
                url: '/twofactor',
                type: 'POST',
                data: $('#authySmsForm').serialize(),
                success: (data) => {
                    $('.token .error').hide();
                    window.location.href = data;
                },
                error: (data) => {
                    $('.token .error').show();
                }
            });
        });
    });
</script>
@endpush
