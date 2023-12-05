<?= $this->extend('template/index') ?>


<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Profile</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
          <li class="breadcrumb-item">Profile</li>
          <li class="breadcrumb-item active">Edit</li>
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
    <form action="<?= base_url('profile'); ?>" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
            <div class="card-header">
              Edit Profile
            </div>
            <div class="card-body">
              <input type='hidden' name='_method' value='PUT' />
              <?= csrf_field(); ?>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" disabled placeholder="Username" value="<?= $data['username']; ?>">
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control <?= ($error = validation_show_error('name')) ? 'border-danger' : ''; ?>" id="name" name="name" value="<?= $data['name']; ?>" placeholder="name">
              </div>
              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control <?= ($error = validation_show_error('email')) ? 'border-danger' : ''; ?>" id="email" name="email" value="<?= $data['email']; ?>" placeholder="email">
              </div>
              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>

              <div class="form-group">
                <label for="image">Image</label>
                <div id="imagePreview">
                  <img class="rounded-circle img-thumbnail d-block mb-2" width="120" src="<?= base_url(); ?>public/assets/uploads/users/<?= $data['image']; ?>" alt="">

                </div>
                <input type="file" class="form-control <?= ($error = validation_show_error('image')) ? 'border-danger' : ''; ?>" id="image" name="image" onchange="previewImage(this, '#imagePreview')">
              </div>
              <?= ($error) ? '<div class="error text-danger mb-2" style="margin-top: -15px">' . $error . '</div>' : ''; ?>

              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="<?= base_url('profile'); ?>" class="btn btn-secondary">Batal</a>


            </div>
          </div>
        </div>
      </div>

    </form>


  </div>
</section>
<?= $this->endSection('content') ?>