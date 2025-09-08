<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.themes') ?>"><?php ee('Themes') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('Theme Editor') ?></h1>
<div class="card rounded-4 card-editor">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="fw-bold">
                <?php ee('Editing') ?> <?php echo ucwords(str_replace(['_', '/'], [' ', ' > '], $file["current"])) ?>
                <span class="d-block text-muted">
                    <small><?php ee('This tool is for advanced users only as it may break your site. Please do not change PHP codes if you are unsure.') ?></small>
                </span>
            </div>
            <div class="ms-auto input-select">
                <select name="theme_files" id="theme_files" data-trigger="redirect" data-name="file" data-toggle="select">
                    <?php foreach($themefiles as $tf): ?>
                        <option value="<?php echo $tf['file'] ?>" <?php echo $file['name'] == $tf['file'] ? 'selected': '' ?>><?php echo $tf['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>
    <form method="post" action="<?php echo route('admin.themes.editor.update', ['file' => $file['name']]) ?>" enctype="multipart/form-data" data-trigger="codeeditor">
        <?php echo csrf() ?>   
        <div class="form-group mb-4">
            <div id="code-editor"><?php echo $file['content'] ?></div>
            <textarea class="d-none" id="code" name="code"></textarea>
        </div>
        <div class="card-body">
            <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Update') ?></button>
        </div>
    </form>
</div>