<?= $this->extend('template/index') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">New <?= $title; ?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
          <li class="breadcrumb-item">Kelola <?= $title; ?></li>
          <li class="breadcrumb-item active">New</li>
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
            New <?= $title; ?>
          </div>
          <div class="card-body">
            <form action="<?= base_url($link); ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field(); ?>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control <?= ($error = validation_show_error('username')) ? 'border-danger' : ''; ?>" id="username" name="username" placeholder="Username" value="<?= old('username'); ?>">
              </div>
              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control <?= ($error = validation_show_error('password')) ? 'border-danger' : ''; ?>" id="password" name="password" placeholder="Password">
              </div>
              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>

              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control <?= ($error = validation_show_error('name')) ? 'border-danger' : ''; ?>" id="name" name="name" placeholder="Name" value="<?= old('name'); ?>">
              </div>
              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control <?= ($error = validation_show_error('email')) ? 'border-danger' : ''; ?>" id="email" name="email" placeholder="email" value="<?= old('email'); ?>">
              </div>
              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>

              <div class="form-group">
                <label for="role_id">Role</label>
                <select name="role_id" id="role_id" class="form-control <?= ($error = validation_show_error('role_id')) ? 'border-danger' : ''; ?>">
                  <?php foreach ($role as $d) : ?>
                    <option value="<?= $d['id']; ?>"><?= $d['title']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>

              <div class="form-group">
                <label for="image">Image</label>
                <div id="imagePreview">
                  <img class="rounded-circle img-thumbnail d-block mb-2" width="120" src="<?= base_url(); ?>public/assets/uploads/users/user.png" alt="">

                </div>
                <input type="file" class="form-control <?= ($error = validation_show_error('image')) ? 'border-danger' : ''; ?>" id="image" name="image" onchange="previewImage(this, '#imagePreview')">
              </div>

              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>

              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="<?= base_url($link); ?>" class="btn btn-secondary">Batal</a>
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
</section>
<?= $this->endSection('content') ?>