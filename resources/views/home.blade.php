@extends('layouts.app')

@section('content')
<div class="container">
        <h2>Did you like this Tutorial? Press like to make it easier for others to see</h2>
        <div class="like">
            <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FHerosonyLearning%2F&width=50&layout=button&action=like&size=small&show_faces=false&share=false&height=65&appId=693081937440422" width="50" height="65" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
        </div>
</div>
@endsection

@push('styles')
<style>
.h_body .container {
    margin-top: 1%;
    max-width: 700px;
}
h2 {
    margin: 0;
    padding: 0;
    font-weight: 300;
    text-align: center;
    font-size: 18px;
}
.like {
    text-align: center;
}
</style>
@endpush