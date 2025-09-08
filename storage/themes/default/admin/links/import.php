<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.links') ?>"><?php ee('Links') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('Import Links') ?></h1>
<div class="row">
    <div class="col-md-6">        
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <p><?php ee('This tool allows you to import links from other software. You need to format the import file as CSV with the following structure. Note that this tool only imports links. It does not import statistics.') ?></p>

                <p><?php ee('When creating the CSV file, you need to keep the header but the column name can be anything as long as their position is respected. If the custom alias is taken, the importer will generate a random alias.') ?></p>

                <p class="my-3"><strong><?php ee('Important') ?></strong></p>
                <p><?php ee('CSV cannot be bigger than {s}mb. If your file contains more than 100 links, links will be imported in the background. Please note that duplicate links will be ignored.', null, ['s' => \Helpers\App::maxSize()]) ?></p>
                
                <form method="post" action="<?php echo route('admin.links.import') ?>" enctype="multipart/form-data" class="mt-5">
                    <?php echo csrf() ?>
                    <div class="form-group">
                        <label for="file" class="form-label fw-bold"><?php ee('CSV File') ?> (.csv)</label>
                        <input type="file" class="form-control" name="file" id="file" accept=".csv">
                    </div>

                    <div class="form-group mt-3">
                        <label for="user" class="form-label fw-bold"><?php ee('User') ?></label>
                        <select name="user" id="user" class="form-control" data-toggle="select">
                            <option value="0"><?php ee('Public/Anonymous') ?></option>
                            <?php foreach($users as $user): ?>
                                <option value="<?php echo $user->id ?>">#<?php echo $user->id ?>: <?php echo $user->email ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="redirect" class="form-label fw-bold"><?php ee('Redirect') ?></label>
                        <select name="redirect" id="redirect" class="form-control" data-toggle="select">
                            <option value="auto"><?php ee('Automatic') ?></option>
                            <option value="direct"><?php ee('Direct') ?></option>
                            <option value="frame"><?php ee('Frame') ?></option>
                            <option value="splash"><?php ee('Splash') ?></option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm mt-3"><?php ee('Import') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">        
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php ee('CSV Format') ?></h5>
                <pre class="bg-dark rounded p-3 text-white mt-3">longurl,alias,title,description</pre>

                <h5 class="card-title mt-3"><?php ee('Sample') ?></h5>
                <pre class="bg-dark rounded p-3 text-white mt-3">longurl,alias,title,description<br>https://google.com,google,Google,Google search engine</pre>
            </div>
        </div>
    </div>
</div>