  @extends('back.layout.auth-layout')
    @section('pageTitle', isset($PageTitle) ? $PageTitle : 'Page Title here')

    @section('content')
    
<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Reset Password</h2>
							</div>  
							<h6 class="mb-20">Enter your new password, confirm and submit</h6>
							<form method="POST" action="{{ route('admin.reset-password-submit', ['token' => $token]) }}">
                            <x-form-alerts></x-form-alerts>
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
								<div class="input-group custom mb-1">
									<input type="password" name="new_password" class="form-control form-control-lg" placeholder="New Password">
									<div class="input-group-append custom">
										<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
									</div>
								</div>
                                @error('new_password')
                                    <div class="text-danger mb-1">{{ $message }}</div>
                                @enderror
								<div class="input-group custom mb-1 mt-3">
									<input type="password" name="new_password_confirmation" class="form-control form-control-lg" placeholder="Confirm New Password">
									<div class="input-group-append custom ">
										<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
									</div>
								</div>
                                @error('new_password_confirmation')
                                    <div class="text-danger mb-1">{{ $message }}</div>
                                @enderror
								<div class="row align-items-center">
									<div class="col-5">
										<div class="input-group mb-0">
                                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">

										</div>
									</div>
								</div>
							</form>
						</div>
  
    @endsection
