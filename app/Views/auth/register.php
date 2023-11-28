<?= $this->extend('template/auth') ?>

<?= $this->section('content') ?>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href=""><b>Admin</b>LTE</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="<?= base_url($link . '/register'); ?>" method="post">
          <?= csrf_field(); ?>
          <div class="input-group ">
            <input type="text" class="form-control" name="name" placeholder="Full name" value="<?= old('name'); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="mb-3 text-danger"><?= validation_show_error('name'); ?></div>
          <div class="input-group">
            <input type="text" class="form-control" name="username" placeholder="Username" value="<?= old('username'); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="mb-3 text-danger"><?= validation_show_error('username'); ?></div>
          <div class="input-group">
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?= old('email'); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="mb-3 text-danger"><?= validation_show_error('email'); ?></div>
          <div class="input-group">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="mb-3 text-danger"><?= validation_show_error('password'); ?></div>
          <div class="input-group">
            <input type="password" class="form-control" name="confirm_password" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="mb-3 text-danger"><?= validation_show_error('confirm_password'); ?></div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                  I agree to the <a href="#">terms</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


        <a href="<?= base_url($link); ?>" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->
  <?= $this->endSection('content') ?>