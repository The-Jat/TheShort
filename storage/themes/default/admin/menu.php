<h1 class="h3 mb-5"><?php ee('Theme Menu') ?></h1>

<div class="row">
    <div class="col-md-4">
        <div class="card rounded-4 card-default">
            <div class="card-header fw-bold pb-0"><?php ee('Customize Menu') ?></div>
            <div class="card-body">
                <form class="form" action="#" method="post" data-trigger="addtomenu">
                    <p class="help-block">
                        <?php ee('You can add custom menu items to the header region. Some items are locked in place and cannot be removed.') ?>
                    </p>
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold" for="title"><?php ee('Title') ?></label>
                        <input class="form-control p-2" type="text" name="title" id="title" value="" placeholder="e.g. Contact"  required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-bold" for="link"><?php ee('Link') ?></label>
                        <input class="form-control p-2" type="text" name="link" id="link" value="" placeholder="https://" required>
                    </div>

                    <?php echo csrf() ?>
                    <input type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm" value="Add to Menu">
                </form>
            </div>
        </div>
        <div class="card rounded-4 card-default">
            <div class="card-header fw-bold pb-0"><?php ee('Link to a Page') ?></div>
            <div class="card-body">
                <form action="#" class="add_custom">
                    <div class="form-group input-select rounded">
                        <select name="pages" class="form-select" data-toggle="select">
                            <?php foreach ($pages as $page): ?>
                                <option value="<?php echo $page->id ?>"><?php echo $page->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3" value="Add">
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <form action="" id="current_menu"  class="border border-2 rounded p-3">
            <div id="sortable">
                <div class="card rounded-4 mb-2">
                    <div class="card-body">
                        <h4 class="mb-0 fw-bold"><?php ee('Solutions') ?></h4>
                    </div>
                </div>
                <div class="card rounded-4 mb-2 ms-4">
                    <div class="card-body">
                        <h5 class="mb-0 fw-bold"><?php ee('Bio Pages') ?> <span class="text-muted small"><?php echo route('bio') ?></span></h5>
                    </div>
                </div>
                <div class="card rounded-4 mb-2 ms-4">
                    <div class="card-body">
                        <h5 class="mb-0 fw-bold"><?php ee('QR Codes') ?> <span class="text-muted small"><?php echo route('qr') ?></span></h5>
                    </div>
                </div>
                <div class="card rounded-4 mb-2">
                    <div class="card-body">
                        <h4 class="mb-0 fw-bold"><?php ee('Pricing') ?> <span class="text-muted small"><?php echo route('pricing') ?></span></h4>
                    </div>
                </div>
                <div class="card rounded-4 mb-2">
                    <div class="card-body">
                        <h4 class="mb-0 fw-bold"><?php ee('Blog') ?> <span class="text-muted small"><?php echo route('blog') ?></span></h4>
                    </div>
                </div>
                <div class="card rounded-4 mb-2">
                    <div class="card-body">
                        <h4 class="mb-0 fw-bold"><?php ee('Resources') ?></span></h4>
                    </div>
                </div>
                <div class="card rounded-4 mb-2 ms-4">
                    <div class="card-body">
                        <h5 class="mb-0 fw-bold"><?php ee('Help Center') ?> <span class="text-muted small"><?php echo route('help') ?></span></h5>
                    </div>
                </div>
                <div class="card rounded-4 mb-2 ms-4">
                    <div class="card-body">
                        <h5 class="mb-0 fw-bold"><?php ee('Developer API') ?> <span class="text-muted small"><?php echo route('apidocs') ?></span></h5>
                    </div>
                </div>
            </div>
            <ul id="sortable">
                <?php $i = 0; ?>
                <?php foreach ($menu as $item): ?>
                    <?php if(!is_array($item)) continue ?>
                    <li>
                        <div class="input-group">
                            <a href="#<?php echo $item["href"] ?>"><?php echo $item["text"] ?>
                                <span class="menu-delete btn btn-danger btn-xs pull-right">Delete</span>
                            </a>
                            <input type="hidden" name="menu[]" value='{"href":"<?php echo $item["href"] ?>","text":"<?php echo $item["text"] ?>","icon":"<?php echo $item["icon"] ?>"}'>
                        </div>
                    </li>
                    <?php if(isset($item["child"])): ?>
                        <?php foreach ($item["child"] as $child): ?>
                        <li class="second-level">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-<?php echo $child["icon"]?>"></i></span>
                                <a href="#<?php echo $child["href"] ?>"><?php echo $child["text"] ?>
                                    <span class="menu-delete btn btn-danger btn-xs pull-right">Delete</span>
                                </a>
                                <input type="hidden" name="menu[]" value='{"href":"<?php echo $child["href"] ?>","text":"<?php echo $child["text"] ?>","icon":"<?php echo $child["icon"] ?>"}'>
                            </div>
                        </li>
                        <?php endforeach ?>
                    <?php endif; ?>
                    <?php $i++; ?>
                <?php endforeach ?>
            </ul>
        </form>
    </div>
</div>

<script>
	  // $("#sortable").sortable({
   //    placeholder: "input_placeholder",
   //    axis: 'y'
   //  });
$("#sortable").sortable({
  connectWith: "#sortable",
  placeholder: "placeholder",
  update: function(event, ui) {
	},
  start: function(event, ui) {
      if(ui.helper.hasClass('second-level')){
          ui.placeholder.removeClass('placeholder');
          ui.placeholder.addClass('placeholder-sub');
      }
      else{
          ui.placeholder.removeClass('placeholder-sub');
          ui.placeholder.addClass('placeholder');
      }
  },
	sort: function(event, ui) {
        var pos;
        if(ui.helper.hasClass('second-level')){
            pos = ui.position.left+20;
            $('#cursor').text(ui.position.left+20);
        }
        else{
            pos = ui.position.left;
            $('#cursor').text(ui.position.left);
        }
        if(pos >= 32 && !ui.helper.hasClass('second-level')){
            ui.placeholder.removeClass('placeholder');
            ui.placeholder.addClass('placeholder-sub');
            ui.helper.addClass('second-level');
            var i = ui.item.prevAll("li:not(.second-level)").index();
            ui.helper.find("input").attr("name","menu[child-"+i+"][]");
        }
        else if(pos < 25 && ui.helper.hasClass('second-level')){
            ui.placeholder.removeClass('placeholder-sub');
            ui.placeholder.addClass('placeholder');
            ui.helper.removeClass('second-level');
            ui.helper.find("input").attr("name","menu[]");
        }
  }
});
$("#sortable li.second-level").each(function(){
    var i = $(this).prevAll("li:not(.second-level)").index();
		$(this).find("input").attr("name","menu[child-"+i+"][]");
})
</script>