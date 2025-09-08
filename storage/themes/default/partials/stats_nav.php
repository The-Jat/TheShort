<ul class="nav nav-tabs border-0 overflow-x">
    <li class="nav-item me-1 flex-fill">
        <a href="<?php echo route('stats', $url->id) ?>" class="nav-link fw-bold text-center"><i class="fa fa-home"></i><span class="align-top ms-2"><?php ee('Summary') ?></span></a>
    </li>
    <li class="nav-item me-1 flex-fill">
        <a href="<?php echo route('stats.countries', $url->id) ?>" class="nav-link fw-bold text-center"><i class="fa fa-map-pin"></i><span class="align-top ms-2"><?php ee('Countries & Cities') ?></span></a>
    </li>
    <li class="nav-item me-1 flex-fill">
        <a href="<?php echo route('stats.platforms', $url->id) ?>" class="nav-link fw-bold text-center"><i class="fa fa-desktop"></i><span class="align-top ms-2"><?php ee('Platforms') ?></span></a>
    </li>
    <li class="nav-item me-1 flex-fill">
        <a href="<?php echo route('stats.browsers', $url->id) ?>" class="nav-link fw-bold text-center"><i class="fab fa-chrome"></i><span class="align-top ms-2"><?php ee('Browsers') ?></span></a>
    </li>
    <li class="nav-item me-1 flex-fill">
        <a href="<?php echo route('stats.languages', $url->id) ?>" class="nav-link fw-bold text-center"><i class="fa fa-user"></i><span class="align-top ms-2"><?php ee('Languages') ?></span></a>
    </li>
    <li class="nav-item me-1 flex-fill">
        <a href="<?php echo route('stats.referrers', $url->id) ?>" class="nav-link fw-bold text-center"><i class="fa fa-globe"></i><span class="align-top ms-2"><?php ee('Referrers') ?></span></a>
    </li>
    <?php if(is_null($url->profileid) && is_null($url->qrid)): ?>
    <li class="nav-item me-1 flex-fill">
        <a href="<?php echo route('stats.abtesting', $url->id) ?>" class="nav-link fw-bold text-center"><i class="fa fa-sync"></i><span class="align-top ms-2"><?php ee('A/B Testing') ?></span></a>
    </li>
    <?php endif ?>
</ul>