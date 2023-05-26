@extends('layouts.app.front-app')
@section('title', 'Test Render Page ' . env('APP_NAME'))
@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <style>
        .save-detail {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
<style type="text/css">
    
}
</style>
    <section class="add-edit-detail lite-gray investor-edit-detail">
       {{-- this how we comment in blade views --}}
       {{-- Now here we expect the logic done in controller to have a today's date to the user by calling a variable this way: '{{$date}}' --}}
        <h1>Heey, today is on {{$leo}}</h1>
        {{-- the viw is complaining that variable $date is not know by it, why?? because we used 'today' as alias name of $date --}}
    </section>

@endsection
@section('custom-js')
    <script>
    //our javascript code excutes after page loads...
        alert('Hey Test page,js code excutes after page renders!');
    </script>

@endsection