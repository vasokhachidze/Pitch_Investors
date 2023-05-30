@extends('layouts.app.front-app')
@section('title', 'Token '.env('APP_NAME'))

@php

$session_data = session('user');
$userData = '';
if ($session_data !== '') {
    $userToken = App\Helper\GeneralHelper::get_myAvailable_token($session_data['iUserId']);
}
@endphp

@section('custom-css')
@endsection
@section('content')
<section class="my-dashbord">
    <div class="container">
        <div class="row">
            @include('layouts.front.left_dashboard')
            <div class="col-lg-12">
                <div class="right-panal-side">
                    <div class="row padding-no">
                        <div class="wallet-warrap">
                            <div class="col-md-12">
                                <div class="wallet-inside-blance">
                                    <div class="wallet-balence">
                                        <h3>Total Available Token</h3>
                                        <h2 class="balence-value">TOKEN {{$userToken->iTotalToken}}</h2>
                                        <p>Current Available Token</p>
                                    </div>
                                    <div class="wallet-balence">
                                        <h3>Hold Token</h3>
                                        <h2 class="balence-value">TOKEN {{$hold_token->holdToken}}</h2>
                                        <p>Currently Hold Token</p>
                                    </div>
                                    <div class="add-money bg-green">
                                        <a href="{{url('plan-listing')}}"><i class="far fa-plus"></i>Add Token</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-4">
                                    <div class="transaction-table">
                                        <h4 class="table-heading">History of Token</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped transaction-value-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Date</th>
                                                        <th class="transaction-text-center" scope="col">Tittle</th>
                                                        <th class="transaction-text-center" scope="col">Phone No</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($connection_list as $key => $connValue)
                                                    <tr>
                                                        <td scope="row">{{date('d-m-Y',strtotime($connValue->dtAddedDate))}}</td>
                                                        <td class="transaction-text-center">{{$connValue->vSenderProfileTitle}}</td>
                                                        <td class="transaction-text-center">{{$connValue->vSenderMobNo}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="transaction-table">
                                        <h4 class="table-heading">History of Purchased plan</h4>
                                        <div class="table-responsive">
                                            <table class="table table-striped transaction-value-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Date</th>
                                                        <th class="transaction-text-center" scope="col">Tittle</th>
                                                        <th class="transaction-text-center" scope="col">Token</th>
                                                        <th class="transaction-text-center" scope="col">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($purchase_token as $key=> $purchaseToken)
                                                    <tr>
                                                        <td scope="row">{{date('d-m-Y',strtotime($purchaseToken->dtAddedDate))}}</td>
                                                        <td class="transaction-text-center">{{$purchaseToken->vPlanTitle}}</td>
                                                        <td class="transaction-text-center">{{$purchaseToken->iNoofConnection}}</td>
                                                        <td class="transaction-text-center amout-growup"><label class="kes">KES</label> {{$purchaseToken->vTokenPrice}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('custom-js')
@endsection