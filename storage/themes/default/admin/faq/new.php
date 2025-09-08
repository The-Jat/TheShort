<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.faq') ?>"><?php ee('Articles') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('New Article') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.faq.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="question" class="form-label fw-bold"><?php ee('Question') ?></label>
                <input type="text" class="form-control p-2" name="question" id="question" value="<?php echo old('question') ?>" placeholder="My Sample Question">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="slug" class="form-label fw-bold"><?php ee('Slug') ?></label>
                        <input type="text" class="form-control p-2" name="slug" id="slug" value="<?php echo old('slug') ?>" placeholder="my-sample-faq">
                        <p><?php ee('Leave this empty to automatically generate it from the title.') ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4 input-select rounded">
                        <label for="category" class="form-label fw-bold"><?php ee('Category') ?></label>
                        <select class="form-control" name="category" id="category" data-toggle="select">
                            <?php foreach(config('faqcategories') as $id => $category): ?>
                                <option value="<?php echo $id ?>"><?php echo strtoupper($category->lang ?? 'en') ?>: <?php echo $category->title ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="answer" class="form-label fw-bold"><?php ee('Answer') ?></label>
                <p class="form-text"><?php ee('Use the rich editor below to write your Article.') ?></p>
                <textarea name="answer" id="editor" class="form-control" placeholder="Type your content here"><?php echo old('answer') ?></textarea>
            </div>	
            <div class="form-group">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" data-binary="true" id="pricing" name="pricing" value="1">
                    <label class="form-check-label" for="pricing"><?php ee('Pricing Page') ?></label>
                </div>
                <p class="form-text"><?php ee('Do you want to show this Article on the pricing page?') ?></p>
            </div>  	                        
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Article') ?></button>
        </form>

    </div>
</div>