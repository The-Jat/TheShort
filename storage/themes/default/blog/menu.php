<section class="border-bottom">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo !isset($current) ? 'border rounded font-weight-700' : '' ?>" href="<?php echo route('blog') ?>"><?php ee('All') ?></a>
                    </li>
                    <?php foreach($menu as $category): ?>
                        <?php if(is_array($category)): ?>
                            <li class="nav-item mr-2">
                                <a class="nav-link" href="#" data-toggle="dropdown" title="" class="dropdown-toggle">
                                    <i class="mr-2 fa fa-ellipsis-h"></i>
                                    <?php ee('More') ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach($category as $child): ?>
                                        <li class="dropdown-item">
                                            <a class="nav-link" href="<?php echo route('blog.category', [$child->slug]) ?>" title="<?php echo $child->name ?>">
                                                <?php if(isset($child->icon) && $child->icon): ?>
                                                    <i class="mr-2 <?php echo $child->icon ?>"></i>
                                                <?php endif ?>
                                                <?php echo $child->name ?>
                                            </a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item mr-2">
                                <a class="nav-link <?php echo isset($current) && $current->id == $category->id ? 'border rounded font-weight-700' : '' ?>" href="<?php echo route('blog.category', [$category->slug]) ?>" title="<?php echo $category->name ?>">
                                    <?php if(isset($category->icon) && $category->icon): ?>
                                            <i class="mr-2 <?php echo $category->icon ?>"></i>
                                    <?php endif ?>
                                    <?php echo $category->name ?>
                                </a>
                            </li>
                        <?php endif ?>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="col-lg-5">
                <form class="rounded-lg border" action="<?php echo route('blog.search') ?>">
                    <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text border-0 pr-2">
                                <i data-feather="search"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control border-0 px-1" name="q" value="<?php echo $q ?? '' ?>" aria-label="Find something" placeholder="<?php ee('Search') ?>...">
                        <div class="input-group-append">
                            <span class="input-group-text border-0 py-0 pl-2 pr-1">
                                <button type="submit" class="btn btn-sm btn-dark"><?php ee('Search') ?></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>