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
                <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Post Details</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="clearfix">
                <div class="card card-bx profile-card author-profile m-b30">
                    <div class="card-body">
                        <div class="p-5">
                            <div class="author-profile">
                                <div class="author-media">
                                    <img src="{{ asset('images/tab/1.jpg') }}" alt="">
                                    <div class="upload-link" title="" data-toggle="tooltip" data-placement="right"
                                        data-original-title="update">
                                        <input type="file" class="update-flie">
                                        <i class="fa fa-camera"></i>
                                    </div>
                                </div>
                                <div class="author-info">
                                    <h6 class="title">Nella Vita</h6>
                                    <span>Developer</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-list">
                            <ul>
                                <li><a href="{{ url('app-profile') }}">Models</a><span>36</span></li>
                                <li><a href="{{ url('uc-lightgallery') }}">Gallery</a><span>3</span></li>
                                <li><a href="{{ url('app-profile') }}">Lessons</a><span>1</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="input-group mb-3">
                            <div class="form-control rounded text-center">Portfolio</div>
                        </div>
                        <div class="input-group">
                            <a href="https://www.dexignlab.com/" target="_blank"
                                class="form-control text-hover rounded ">https://www.dexignlab.com/</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8">
            <div class="card profile-card card-bx m-b30">
                <div class="card-header">
                    <h4 class="card-title">Account setup</h4>
                </div>
                <form class="profile-form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="Name">Name</label>
                                    <input type="text" class="form-control" value="John" id="Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="Surname">Surname</label>
                                    <input type="text" class="form-control" value="osib" id="Surname">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="Specialty">Specialty</label>
                                    <input type="text" class="form-control" value="Developer" id="Specialty">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="Skills">Skills</label>
                                    <input type="text" class="form-control" value="HTML,  JavaScript,  PHP"
                                        id="Skills">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <select class="default-select form-control" id="validationCustom05">
                                        <option data-display="Select">Please select</option>
                                        <option value="html">Male</option>
                                        <option value="css">Female</option>
                                        <option value="javascript">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="datepicker">DOB</label>
                                    <div class="input-hasicon mb-xl-0 mb-3">
                                        <input class="form-control mb-xl-0 mb-3 bt-datepicker" type="text"
                                            id="datepicker">
                                        <div class="icon"><i class="far fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="number" class="form-control" value="12345" pattern="[0-9]"
                                        maxlength="10">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="Email">Email address</label>
                                    <input type="text" class="form-control" value="demo@gmail.com"
                                        id="Email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Country</label>
                                    <select class="default-select form-control" id="validationCustom01">
                                        <option data-display="Select">Please select</option>
                                        <option value="russia">Russia</option>
                                        <option value="canada">Canada</option>
                                        <option value="china">China</option>
                                        <option value="india">India</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 m-b30">
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <select class="default-select form-control" id="validationCustom02">
                                        <option data-display="Select">Please select</option>
                                        <option>Krasnodar</option>
                                        <option>Tyumen</option>
                                        <option>Chelyabinsk</option>
                                        <option>Moscow</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">UPDATE</button>
                        <a href="" class="text-hover float-end">Forgot your password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection