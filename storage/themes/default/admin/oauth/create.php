<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.oauth') ?>"><?php ee('OAuth Applications') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('Create OAuth Application') ?></h1>
<div class="card rounded-4">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.oauth.create') ?>">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="name" class="form-label fw-bold"><?php ee('Application Name') ?></label>
                <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo old('name') ?>" required>
            </div>
            <div class="form-group mb-4">
                <label for="redirect_uri" class="form-label fw-bold"><?php ee('Redirect URI') ?></label>
                <input type="text" class="form-control p-2" name="redirect_uri" id="redirect_uri" value="<?php echo old('redirect_uri') ?>" required>
                <p class="form-text"><?php ee('The redirect URI is where the user will be redirected after authorization') ?></p>
            </div>
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Create Application') ?></button>
        </form>
    </div>
</div>