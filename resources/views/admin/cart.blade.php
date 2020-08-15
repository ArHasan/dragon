@extends('frontend.frontend')

@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Shop Page</h2>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><span>Shop</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- cart-area start -->
<div class="cart-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(session('invalid_error'))
                <div class="alert alert-danger">
                    {{ session('invalid_error') }}
                </div>
                @endif
                @if(session('no_exists'))
                <div class="alert alert-danger">
                    {{ session('no_exists') }}
                </div>
                @endif
                <form action="{{ url('card/update')}}" method="POST">
                    @csrf
                    <table class="table-responsive cart-wrap">
                        <thead>
                            <tr>
                                <th class="images">Image</th>
                                <th class="product">Product</th>
                                <th class="ptice">Price</th>
                                <th class="quantity">Quantity</th>
                                <th class="total">Total</th>
                                <th class="remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sub_total_cart=0;
                            $flag=0;
                            @endphp
                            @forelse($carts as $cart)
                            <tr>
                                <td class="images"><img
                                        src="{{ asset('uploads/product_photo') }}/{{ App\Product::find($cart->product_id)->product_thumbnail_photo  }}"
                                        alt=""></td>
                                <td class="product"><a
                                        href="{{ route('shop') }}">{{ App\Product::find($cart->product_id)->product_name }} <br> Available quantity : {{ App\Product::find($cart->product_id)->product_quantity }} </a>
                                      @if( App\Product::find($cart->product_id)->product_quantity < $cart->quantity)
                                     <br> <span class="text-danger">You have to remove or decrease product</span>
                                         @php
                                             $flag++;
                                         @endphp
                                      @endif

                                </td>
                                <td class="ptice">${{ App\Product::find($cart->product_id)->product_price }}</td>
                                <td class="quantity cart-plus-minus">
                                    <input type="text" value="{{ $cart->quantity }}"
                                        name="cart_quantity[{{ $cart->id }}]" />
                                </td>
                                <td class="total">
                                    ${{ App\Product::find($cart->product_id)->product_price * $cart->quantity }}
                                    @php
                                    $sub_total_cart= $sub_total_cart +
                                    (App\Product::find($cart->product_id)->product_price * $cart->quantity);
                                    @endphp
                                </td>
                                <td class="remove">
                                    <a href="{{ url('card\delete') }}/{{ $cart->id }}"><i class="fa fa-times"></i></a>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td>No Data to show</td>
                            </tr>
                            @endforelse


                        </tbody>
                    </table>
                    <div class="row mt-60">
                        <div class="col-xl-4 col-lg-5 col-md-6 ">
                            <div class="cartcupon-wrap">
                                <ul class="d-flex">
                                    <li>
                                        <button type="submit">Update Cart</button>
                                    </li>
                </form>
                <li><a href="{{ route('shop') }}">Continue Shopping</a></li>
                </ul>
                <h3>Cupon</h3>
                <p>Enter Your Cupon Code if You Have One</p>
                <div class="cupon-wrap">
                    <input type="text" placeholder="Cupon Code" id="coupon_text">
                    <span class="couponbtn" id="apply-coupon-btn">Apply Cupon</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
            <div class="cart-total text-right">
                <h3>Cart Totals</h3>
                <ul>
                    <li><span class="pull-left">Subtotal </span>${{ $sub_total_cart }}</li>
                    @isset($discount_amount)
                    <li><span class="pull-left"> Discount Amount (-{{ $discount_amount}}%) </span>{{ $sub_total_cart * $discount_amount/100 }} </li>
                    @endisset
                    @isset($discount_amount)
                    <li><span class="pull-left"> Total </span> {{$final_total = $sub_total_cart - ($sub_total_cart * $discount_amount)/100 }}</li>
                    @else
                    <li><span class="pull-left"> Total </span>${{ $final_total = $sub_total_cart }} </li>
                    @endisset
                </ul>
                @if($flag==0)
                <form action="{{ url('checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="total" value="{{$final_total}}">
                    <button type="submit" class="btn btn-danger">Proceed to Checkout</button>
                </form>
                @endif

            </div>
        </div>
    </div>

</div>
</div>
</div>
</div>
<!-- cart-area end -->
@endsection
