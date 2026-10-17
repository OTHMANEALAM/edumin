@extends('layouts.default')
@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Hi, welcome back!</h4>
                <p class="mb-0">Your business dashboard template</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Shop</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Grid</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                            <a href="{{ url('ecom-product-detail') }}"><img class="img-fluid" src="{{ asset('images/product/1.jpg') }}"
                                    alt=""></a>
                        </div>
                        <div class="new-arrival-content text-center mt-3">
                            <h4><a href="{{ url('ecom-product-detail') }}">School Bag</a></h4>
                            <ul class="star-rating">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                <li><i class="fa-solid fa-star-half-stroke"></i></li>
                            </ul>
                            <del class="discount">$1,259</del>
                            <span class="price">$761.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                            <a href="{{ url('ecom-product-detail') }}"><img class="img-fluid" src="{{ asset('images/product/2.jpg') }}"
                                    alt=""></a>
                        </div>
                        <div class="new-arrival-content text-center mt-3">
                            <h4><a href="{{ url('ecom-product-detail') }}">Color Pencils</a></h4>
                            <ul class="star-rating">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span class="price">$159.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                            <a href="{{ url('ecom-product-detail') }}"><img class="img-fluid" src="{{ asset('images/product/3.jpg') }}"
                                    alt=""></a>
                        </div>
                        <div class="new-arrival-content text-center mt-3">
                            <h4><a href="{{ url('ecom-product-detail') }}">Pencils</a></h4>
                            <ul class="star-rating">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <del class="discount">$745</del>
                            <span class="price">$357.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                            <a href="{{ url('ecom-product-detail') }}"><img class="img-fluid" src="{{ asset('images/product/4.jpg') }}"
                                    alt=""></a>
                        </div>
                        <div class="new-arrival-content text-center mt-3">
                            <h4><a href="{{ url('ecom-product-detail') }}">Stapler</a></h4>
                            <ul class="star-rating">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                <li><i class="fa-solid fa-star-half-stroke"></i></li>
                            </ul>
                            <span class="price">$654.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                            <a href="{{ url('ecom-product-detail') }}"><img class="img-fluid" src="{{ asset('images/product/5.jpg') }}"
                                    alt=""></a>
                        </div>
                        <div class="new-arrival-content text-center mt-3">
                            <h4><a href="{{ url('ecom-product-detail') }}">Project Book</a></h4>
                            <ul class="star-rating">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span class="price">$369.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                            <a href="{{ url('ecom-product-detail') }}"><img class="img-fluid" src="{{ asset('images/product/6.jpg') }}"
                                    alt=""></a>
                        </div>
                        <div class="new-arrival-content text-center mt-3">
                            <h4><a href="{{ url('ecom-product-detail') }}">Colorful Book</a></h4>
                            <ul class="star-rating">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <del class="discount">$452</del>
                            <span class="price">$245.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                            <a href="{{ url('ecom-product-detail') }}"><img class="img-fluid" src="{{ asset('images/product/7.jpg') }}"
                                    alt=""></a>
                        </div>
                        <div class="new-arrival-content text-center mt-3">
                            <h4><a href="{{ url('ecom-product-detail') }}">Notebook</a></h4>
                            <ul class="star-rating">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <del class="discount">$678</del>
                            <span class="price">$364.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                            <a href="{{ url('ecom-product-detail') }}"><img class="img-fluid" src="{{ asset('images/product/1.jpg') }}"
                                    alt=""></a>
                        </div>
                        <div class="new-arrival-content text-center mt-3">
                            <h4><a href="{{ url('ecom-product-detail') }}">Project file</a></h4>
                            <ul class="star-rating">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                <li><i class="fa-solid fa-star-half-stroke"></i></li>
                            </ul>
                            <span class="price">$548.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection