@extends('layouts.dashboard_master')
@section('coupon')
active
@endsection
@section('content')
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="index.html">Starlight</a>
    <span class="breadcrumb-item active">Dashboard</span>
</nav>

<div class="sl-pagebody">
    <div class="row justify-content-center">
        <div class="col-md-9">
            @if (session('update_status'))
            <div class="alert alert-success" role="alert">
                {{ session('update_status') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header bg-primary text-light">
                    <h4>Coupon list </h4>
                </div>
                <div class="card-body bg-light">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Coupon name</th>
                                <th scope="col">Discount Amount (%)</th>
                                <th scope="col"> Validity </th>
                                <th scope="col"> Validity Status </th>
                                <th scope="col"> Created At </th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                            <tr class="text-center">
                                <th scope="row">{{$coupon->id}}</th>
                                <td>{{ $coupon->coupon_name }}</td>
                                <td>{{ $coupon->discount_amount }}%</td>
                                <td>{{ $coupon->validity_date }}</td>
                                <td>
                                    @if($coupon->validity_date >= Carbon\Carbon::now()->format('Y-m-d'))
                                    <span class="badge badge-success">Valid</span>
                                    @else
                                    <span class="badge badge-danger">Invalid</span>
                                    @endif

                                </td>
                                <td>{{ $coupon->created_at }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center text-danger" colspan="50"> NO Data Show</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-light  ">
                    <h3>Add Coupon</h3>
                </div>
                <div class="card-body bg-light">
                    @if (session('success_massage'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success_massage') }}
                    </div>
                    @endif

                    <form action="{{url('add/coupon/post')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="category font-weight-bold"> Coupon name </label>
                            <input type="text" name='coupon_name' class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="category font-weight-bold"> Discount Amounte (%) </label>
                            <input type="text" name='discount_amount' class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="category font-weight-bold"> Validity Till  </label>
                            <input type="date" name='validity_date' class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>

                        <button type="submit" class="btn btn-success ">Add Coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- sl-pagebody -->

@endsection
