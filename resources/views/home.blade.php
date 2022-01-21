@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pt-5">{{ __('لوحة التحكم') }}</div>

                <div class="card-body text-right">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                     {{ __('مرحبا بك') .' '.session()->get('user_data')['user_inf'][0]['NAME'] }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
