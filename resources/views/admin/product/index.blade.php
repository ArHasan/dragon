@extends('layouts.dashboard_master')
@section('product')
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
            @if (session('delete_status'))
            <div class="alert alert-danger" role="alert">
                {{ session('delete_status') }}
            </div>
            @endif

            @if (session('restore_status'))
            <div class="alert alert-warning" role="alert">
                {{ session('restore_status') }}
            </div>
            @endif

            @if (session('forcedelete_status'))
            <div class="alert alert-success" role="alert">
                {{ session('forcedelete_status') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header bg-primary text-light">
                    <h4>Product list </h4>
                </div>
                <div class="card-body bg-light">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Product name</th>
                                <th scope="col">Category ID</th>
                                <th scope="col">Product price</th>
                                <th scope="col">Product quantity</th>
                                <th scope="col">Category Photo</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <th scope="row">{{$product->id}}</th>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->relationtocategorytable->category_name}}</td>
                                {{-- <td>{{App\Category::find($product->category_id)->category_name}}</td> --}}
                                <td>${{$product->product_price}}</td>
                                <td>{{$product->product_quantity}}</td>

                                <td>
                                    <img src="{{asset('uploads/product_photo/'.$product->product_thumbnail_photo)}}"
                                        alt="Image" width="100"></td>
                                <td>
                                    <div class="btn-group text-light" role="group" aria-label="Basic example">
                                        <a href="{{url('update/category')}}/{{$product->id}}" type="button"
                                            class="btn btn-primary ">Update</a>
                                        <a href="{{url('delete/category')}}/{{$product->id}}" type="button"
                                            class="btn btn-danger ">Delete</a>
                                    </div>
                                </td>
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
            <div class="card mt-5">
                <div class="card-header bg-warning text-light ">
                    <h4>Deleted Product list</h4>
                </div>
                <div class="card-body bg-light">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Category name</th>
                                <th scope="col">User name</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Updated At</th>
                                <th scope="col">Category Photo</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                            {{-- <tbody>
                                @forelse($delete_categories as $delete_category)
                                <tr>
                                    <th scope="row">{{$delete_category->id}}</th>
                                    <td>{{$delete_category->category_name}}</td>
                                    <td>{{App\user::find($delete_category->user_id)->name}}</td>
                                    <td>
                                        @if($delete_category->created_at)
                                        {{$delete_category->created_at->diffForHumans() }}
                                        @else
                                        NO DATA
                                        @endif
                                    </td>
                                    <td>
                                        @if($delete_category->updated_at)
                                        {{$delete_category->updated_at->diffForHumans() }}
                                        @else
                                        <h1 class="d-flex justify-content-center ">-</h1>
                                        @endif
                                    </td>
                                    <td>
                                        <img src="{{asset('uploads/category_photo/'.$delete_category->category_photo)}}"
                                            alt="Image" width="100"></td>
                                    </td>
                                    <td>
                                        <div class="btn-group text-light" role="group" aria-label="Basic example">
                                            <a href="{{url('restore/category')}}/{{$delete_category->id}}" type="button"
                                                class="btn btn-success ">Restore</a>
                                            <a href="{{url('hard_delete/category')}}/{{$delete_category->id}}" type="button"
                                                class="btn btn-danger  ">P-Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                    @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="50"> NO Data Show</td>
                                </tr>

                                @endforelse
                            </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-light  ">
                    <h3>Add Product</h3>
                </div>
                <div class="card-body bg-light">
                    @if (session('success_massage'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success_massage') }}
                    </div>
                    @endif

                    <form action="{{url('/add/product/post')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="category font-weight-bold"> Product name </label>
                            <input type="text" name='product_name' class="form-control" id="category"
                                placeholder="Enter product name ">
                            <span class="text-danger">
                                @error('product_name')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="category font-weight-bold"> Category Name</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select One</option>
                                @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach

                            </select>
                            <span class="text-danger">
                                @error('category_id ')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="product_price font-weight-bold"> Product price </label>
                            <input type="text" name='product_price' class="form-control" id="product_price"
                                placeholder="Enter product price ">
                            <span class="text-danger">
                                @error('product_price')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="product_quantity font-weight-bold"> Product Quantity </label>
                            <input type="text" name='product_quantity' class="form-control" id="product_quantity"
                                placeholder="Enter product quantity ">
                            <span class="text-danger">
                                @error('product_quantity')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="a font-weight-bold"> Product short description </label>
                           <textarea name="product_short_description" id="a" class="form-control"  ></textarea>
                            <span class="text-danger">
                                @error('product_short_description')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="a font-weight-bold"> Product long description </label>
                           <textarea name="product_long_description" id="a" class="form-control"  ></textarea>
                            <span class="text-danger">
                                @error('product_long_description')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label >Product thumbnail photo</label>
                            <input type="file" name="product_thumbnail_photo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label >Product Multiple photos</label>
                            <input type="file" name="product_multiple_photos[]" class="form-control" multiple>
                        </div>

                        <button type="submit" class="btn btn-success ">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- sl-pagebody -->

@endsection
