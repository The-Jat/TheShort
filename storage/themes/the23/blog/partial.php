<div class="card border-0 shadow-sm mb-5">
    <?php if($post->image): ?>
        <div class="position-relative">
            <a href="<?php echo route('blog.post', $post->slug) ?>" class="d-block">
                <img alt="<?php echo $post->title ?>" src="<?php echo uploads($post->image, 'blog') ?>" class="card-img-top">
            </a>
        </div>
    <?php endif ?>
    <div class="card-body p-4 p-md-5">
        <a href="<?php echo route('blog.post', $post->slug) ?>" class="h5 mt-0"><?php echo $post->title ?></a>
        <div class="my-3">
            <?php if($post->avatar): ?>
                <img alt="<?php echo $post->title ?>" src="<?php echo $post->avatar ?>" class="avatar-xs rounded-circle mr-2">
            <?php endif ?>
            <span class="mb-0 ms-1"><?php ee('By') ?> <?php echo $post->author ?></span>
            <?php if(isset($categories) && $post->categoryid): ?>
                   <?php ee('in') ?> <a href="<?php echo route('blog.category', [$categories[$post->categoryid]->slug]) ?>" title="<?php echo $categories[$post->categoryid]->name ?>"><?php echo $categories[$post->categoryid]->name ?></a>
            <?php endif ?>            
            <span class="ms-4"><i class="fa fa-calendar me-2"></i> <?php echo $post->date ?></span>
        </div>
        <div class="my-4"><?php echo $post->content ?></div>
        <a href="<?php echo route('blog.post', $post->slug) ?>" class="btn btn-primary"><?php ee('Read more') ?></a>
    </div>
</div>