@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card twofactor" style="display:">{{-- Card Twofactor Form --}}
        <h1 class="title">Twofactor 
            <span class="animated bounceIn error">Your credential was bad.</span>
        </h1>

        <div class="row">
            <form class="col s12" action="#" id="twofactor">
                {{ csrf_field() }}

                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" id="authy-token" name="token" class="validate">
                        <label for="token">Enter Token</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12" style="text-align:center">
                        <button type="submit" class="waves-effect waves-light btn" 
                        >Verify</button>
                    </div>
                </div>

            </form>
        </div>
    </div>{{-- End Card Twofactor Form --}}

</div>

@endsection
@push('scripts')
<script>
    
    $(document).ready(function() {
        $('#twofactor').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '/twofactor',
                type: 'POST',
                data: $(e.currentTarget).serialize(),
                success: (data) => {
                    window.location.href = data;
                },
                error: (data) => {
                    console.log(data);
                }
            })

        });
    });

</script>
@endpush