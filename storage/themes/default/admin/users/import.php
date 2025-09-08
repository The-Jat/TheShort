<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.users') ?>"><?php ee('Users') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('Import Users') ?></h1>
<div class="row">
    <div class="col-md-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <p><?php ee('This tool allows you to import users from other software. You need to format the import file as CSV with the following structure. Note that the password will be randomly generated and users will be required to use the password reset tool to reset their password. The plan id and expiration date are optional.') ?></p>

                <p><?php ee('When creating the CSV file, you need to keep the header but the column name can be anything as long as their position is respected.') ?></p>

                <p class="my-3"><strong><?php ee('Important') ?></strong></p>
                <p><?php ee('CSV cannot be bigger than {s}mb.', null, ['s' => \Helpers\App::maxSize()]) ?></p>

                <form method="post" action="<?php echo route('admin.users.import') ?>" enctype="multipart/form-data" class="mt-4">
                    <?php echo csrf() ?>
                    <div class="form-group">
                        <label for="file" class="form-label fw-bold"><?php ee('CSV File') ?> (.csv)</label>
                        <input type="file" class="form-control" name="file" id="file" accept=".csv">
                    </div>

                    <button type="submit" class="btn btn-success mt-3"><?php ee('Import') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php ee('CSV Format') ?></h5>
                <pre class="bg-dark rounded p-3 text-white mt-3">username,email,planid,expirationdate</pre>

                <h5 class="card-title mt-3"><?php ee('Sample') ?></h5>
                <pre class="bg-dark rounded p-3 text-white mt-3">username,email,planid,expirationdate<br>username,user1@email.com,1,2025-01-01</pre>
            </div>
        </div>
    </div>
</div>