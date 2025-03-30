@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
</div>

<section class="section dashboard">
    <div class="row">
        <!-- Card -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Chào mừng, {{ Auth::user()->name }}</h5>
                    <p>Đây là trang quản trị của bạn.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
