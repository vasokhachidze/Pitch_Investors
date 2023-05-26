@extends('layouts.app.admin-app')
@section('title', 'Page Setting View - '.env('APP_NAME'))
@section('content')
<section class="content-header">
   <section class="content">
	<div class="content container-fluid">
        <div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
                        <h4 class="card-title">Page Setting</h4>
                    </div>
                    <div class="card-body">
					<div class="listing-page">
						<div class="container">
							@foreach($data as $key=>$value)
								<div class="centered">
									{!! $value->tPageSection !!}
								</div>			
							@endforeach
						</div>
					</div>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>
</section>
</section>



@endsection

@section('custom-css')

@endsection

@section('custom-js')
@endsection