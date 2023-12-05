<?= $this->extend('template/index') ?>


<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Change Password</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
          <li class="breadcrumb-item">Profile</li>
          <li class="breadcrumb-item active">Change Password</li>
        </ol>
      </div>
      <!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header">
            Change Password
          </div>
          <div class="card-body">
            <form action="<?= base_url($link); ?>" method="post">
              <?= csrf_field(); ?>
              <input type='hidden' name='_method' value='PUT' />
              <div class="form-group">
                <label for="password_old">Password Old</label>
                <input type="password" class="form-control <?= ($error = validation_show_error('password_old')) ? 'border-danger' : ''; ?>" id="password_old" name="password_old" required placeholder="Password Old">
              </div>
              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>
              <div class="form-group">
                <label for="password_new">Password New</label>
                <input type="password" class="form-control" id="password_new" name="password_new" required placeholder="Password New">
              </div>
              <div class="form-group">
                <label for="password_retype">Password Retype</label>
                <input type="password" class="form-control" id="password_retype" name="password_retype" required placeholder="Password Retype">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
</section>
<?= $this->endSection('content') ?>