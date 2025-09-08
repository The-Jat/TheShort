<div class="card border-0 shadow-sm p-3 rounded-3">
    <div class="row align-items-center">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo !isset($current) ? 'border rounded fw-bolder' : 'text-dark' ?>" href="<?php echo route('blog') ?>"><?php ee('All') ?></a>
                </li>
                <?php foreach($menu as $category): ?>
                    <?php if(is_array($category)): ?>
                        <li class="nav-item me-2">
                            <a class="nav-link text-dark" href="#" data-bs-toggle="dropdown" title="" class="dropdown-toggle">
                                <i class="me-2 fa fa-ellipsis-h"></i>
                                <?php ee('More') ?>
                            </a>
                            <ul class="dropdown-menu px-2">
                                <?php foreach($category as $child): ?>
                                    <li class="dropdown-item">
                                        <a class="nav-link <?php echo isset($current) && $current->id == $child->id ? 'active' : 'text-dark' ?>" href="<?php echo route('blog.category', [$child->slug]) ?>" title="<?php echo $child->name ?>">
                                            <?php if(!empty($child->icon)): ?>
                                                <i class="me-2 <?php echo $child->icon ?>"></i>
                                            <?php endif ?>
                                            <?php echo $child->name ?>
                                        </a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item me-2">
                            <a class="nav-link <?php echo isset($current) && $current->id == $category->id ? 'border rounded fw-bolder' : 'text-dark' ?>" href="<?php echo route('blog.category', [$category->slug]) ?>" title="<?php echo $category->name ?>">
                                <?php if(!empty($category->icon)): ?>
                                    <i class="me-2 <?php echo $category->icon ?>"></i>
                                <?php endif ?>
                                <?php echo $category->name ?>
                            </a>
                        </li>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="col-lg-5">
            <form class="rounded-3 border" action="<?php echo route('blog.search') ?>">
                <div class="input-group p-2 d-flex align-items-center">
                    <span class="mx-2">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" class="form-control border-0" name="q" value="<?php echo $q ?? '' ?>" aria-label="Find something" placeholder="<?php ee('Search') ?>...">
                    <span>
                        <button type="submit" class="btn btn-sm btn-primary"><?php ee('Search') ?></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>