<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.users') ?>"><?php ee('Users') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('User Testimonials') ?></h1>
<div class="row">
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.testimonial.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
                        <label for="name" class="form-label fw-bold"><?php ee('Name') ?></label>
                        <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo old('name') ?>" placeholder="E.g John Doe" required>
                    </div>  
                    <div class="form-group mb-4">
                        <label for="email" class="form-label fw-bold"><?php ee('Email') ?></label>
                        <input type="text" class="form-control p-2" name="email" id="email" value="<?php echo old('email') ?>" placeholder="E.g johndoe@apple.com">
                        <p class="form-text"><?php ee("If the email is provided, gravatar will be used to display the user's avatar.") ?></p>
                    </div>
                    <div class="form-group mb-4">
                        <label for="avatar" class="form-label fw-bold"><?php ee('Avatar') ?> (<?php ee('Optional') ?>)</label>
                        <input type="file" class="form-control p-2" name="avatar" id="avatar">
                    </div>                    
                    <div class="form-group mb-4">
                        <label for="job" class="form-label fw-bold"><?php ee('Job Title') ?></label>
                        <input type="text" class="form-control p-2" name="job" id="job" value="<?php echo old('job') ?>" placeholder="E.g Web Developer">
                        <p class="form-text"><?php ee("User's title or company") ?></p>
                    </div>                    
                    <div class="form-group mb-4">
                        <label for="testimonial" class="form-label fw-bold"><?php ee('Testimonial') ?></label>
                        <textarea name="testimonial" id="testimonial" rows="2" class="form-control"><?php echo old('testimonial') ?></textarea>
                    </div>		                                         
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Testimonial') ?></button>
                </form>
            </div>
        </div>     
    </div>
    <div class="col-md-8">
        <div class="card rounded-4 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('User') ?></th>
                            <th width="70%"><?php ee('Testimonial') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($testimonials as $id => $testimonial): ?>
                            <tr>
                                <td><?php echo $testimonial->avatar ? '<img src="'.$testimonial->avatar.'" class="rounded-circle" width="30">': '' ?> <?php echo $testimonial->name ?> <?php echo $testimonial->job  ? "({$testimonial->job})" : "" ?></td>
                                <td><?php echo $testimonial->testimonial ?></td>
                                <td>
                                    <button type="button" class="btn btn-default  bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.testimonial.delete', [$id+1, \Core\Helper::nonce('testimonial.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Are you sure you want to delete this?') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to delete a record. This action is permanent and cannot be reversed.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>