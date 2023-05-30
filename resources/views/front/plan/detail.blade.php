@extends('layouts.app.front-app')
@section('title', 'Plan Detail - ' . env('APP_NAME'))
@section('content')
    <!-- Main content -->
    <div class="container-fluid" style="margin-top:5%">
        <div class="container p-5">
            <h3>
                Plan Detail
            </h3>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-4">
                                    Price
                                </div>
                                <div class="col-lg-8">
                                    : $100
                                </div>
                                <div class="col-lg-4">
                                    No of Connections
                                </div>
                                <div class="col-lg-8">
                                    : 10
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <style></style>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            
        });
    </script>
@endsection