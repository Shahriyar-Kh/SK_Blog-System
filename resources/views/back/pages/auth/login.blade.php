  @extends('back.layout.auth-layout')
    @section('pageTitle', isset($PageTitle) ? $PageTitle : 'Page Title here')

    @section('content')
    <div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Login Sk Blog System</h2>
							</div>
							<form action="{{ route('admin.login_submit') }}" method="POST">
								<x-form-alerts></x-form-alerts>
                                @csrf
								<div class="input-group custom mb-1">
									<input type="text" class="form-control form-control-lg" placeholder="Username/Email" name="login_id" value="{{ old('login_id') }}">
									<div class="input-group-append custom">
										<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
									</div>
								</div>
                                @error('login_id')
                                    <div class="text-danger mb-1">{{ $message }}</div>
                                @enderror
								<div class="input-group custom mb-1">
									<input type="password" class="form-control form-control-lg" placeholder="**********" name="password">
									<div class="input-group-append custom">
										<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
									</div>
								</div>
                                @error('password')
                                    <div class="text-danger mb-1">{{ $message }}</div>
                                @enderror
								<div class="row pb-30">
									<div class="col-6">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="customCheck1">
											<label class="custom-control-label" for="customCheck1">Remember</label>
										</div>
									</div>
									<div class="col-6">
										<div class="forgot-password">
											<a href="forgot-password.html">Forgot Password</a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group mb-0">
										
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
								
									</div>
								</div>
							</form>
						</div>
    @endsection
