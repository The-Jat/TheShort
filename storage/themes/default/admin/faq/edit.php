<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.faq') ?>"><?php ee('Articles') ?></a></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Edit Article') ?></h1>
    <div class="ms-auto">
        <a href="<?php echo route('help.single', $faq->slug) ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm" target="_blank"><?php ee('View') ?></a>
    </div>
</div>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.faq.update', [$faq->id]) ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="question" class="form-label fw-bold"><?php ee('Question') ?></label>
                <input type="text" class="form-control p-2" name="question" id="question" value="<?php echo $faq->question ?>" placeholder="My Sample Question">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="slug" class="form-label fw-bold"><?php ee('Slug') ?></label>
                        <input type="text" class="form-control p-2" name="slug" id="slug" value="<?php echo $faq->slug ?>" placeholder="my-sample-faq">
                        <p><?php ee('Leave this empty to automatically generate it from the title.') ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4 input-select">
                        <label for="category" class="form-label fw-bold"><?php ee('Category') ?></label>
                        <select class="form-control" name="category" id="category" data-toggle="select">
                            <?php foreach(config('faqcategories') as $id => $category): ?>
                                <option value="<?php echo $id ?>" <?php echo $id == $faq->category ? 'selected' : '' ?>><?php echo strtoupper($category->lang ?? 'en') ?>: <?php echo $category->title ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="answer" class="form-label fw-bold"><?php ee('Answer') ?></label>
                <p class="form-text"><?php ee('Use the rich editor below to write your Article.') ?></p>
                <textarea name="answer" id="editor"><?php echo $faq->answer ?></textarea>
            </div>	
            <div class="form-group">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" data-binary="true" id="pricing" name="pricing" value="1" <?php echo $faq->pricing ? 'checked' : '' ?>>
                    <label class="form-check-label" for="pricing"><?php ee('Pricing Page') ?></label>
                </div>
                <p class="form-text"><?php ee('Do you want to show this Article on the pricing page?') ?></p>
            </div>  	                        
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Update Article') ?></button>
        </form>

    </div>
</div>