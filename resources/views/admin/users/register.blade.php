<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<section class="vh-100" style="background-color:rgb(255, 255, 255);">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                alt="login form" class="img-fluid" style="width: 100%; height: 100%;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

              @include('admin.alert.alert-not-enter')

              <form action="{{ route('admin.register.post') }}" method="POST">                 
              @csrf                 

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <!-- <span class="h1 fw-bold mb-0">Logo</span> -->
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Đăng Ký Tài Khoản</h5>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example17">Họ và tên</label>
                    <input name="name" type="text" id="form2Example17" 
                    class="form-control form-control-lg" 
                    value="{{ old('name') }}" 
                    />                   
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example17">Email</label>
                    <input name="email" type="email" id="form2Example17" 
                    class="form-control form-control-lg" 
                    value="{{ old('email') }}" 
                    />                   
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example17">Số điện thoại</label>
                    <input name="phone" type="tel" id="form2Example17" 
                    class="form-control form-control-lg" 
                    value="{{ old('phone') }}" 
                    />                   
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example17">Số điện thoại</label>
                    <input name="address" type="tel" id="form2Example17" 
                    class="form-control form-control-lg" 
                    value="{{ old('address') }}" 
                    />                   
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example27">Mật khẩu</label>
                    <input name="password" placeholder="" type="password" id="form2Example27" 
                    class="form-control form-control-lg" 
                    value="{{ old('password') }}" 
                    />
                  </div>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example27">Xác nhận mật khẩu</label>
                    <input name="password_confirmation" placeholder="" type="password" id="form2Example27" 
                    class="form-control form-control-lg" 
                    value="{{ old('password_confirmation') }}" 
                    />
                  </div>
                  <div class="pt-1 mb-4">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                  </div>

                  <a href="#!" class="small text-muted">Terms of use.</a>
                  <a href="#!" class="small text-muted">Privacy policy</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 