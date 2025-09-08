<h1 class="h3 mb-5 fw-bold"><?php ee('Import Links') ?></h1>
<div class="row">
    <div class="col-md-8">        
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <p><?php ee('This tool allows you to import links from other software. You need to format the import file as CSV with the following structure. Note that this tool only imports links. It does not import statistics.') ?></p>

                <p><?php ee('When creating the CSV file, you need to keep the header but the column name can be anything as long as their position is respected. If the custom alias is taken, the importer will generate a random alias.') ?></p>
                
                <h5 class="card-title"><?php ee('CSV Format') ?></h5>
                <pre class="bg-dark rounded p-3 text-white mt-3">longurl,alias,title,description</pre>

                <h5 class="card-title mt-3"><?php ee('Sample') ?></h5>
                <pre class="bg-dark rounded p-3 text-white mt-3">longurl,alias,title,description<br>https://google.com,google,Google,Google search engine</pre>
                
                <p class="my-3"><strong><?php ee('Important') ?></strong></p>
                <p><?php ee('CSV cannot be bigger than {s}mb. If your file contains more than 100 links, links will be imported in the background. Please note that duplicate links will be ignored.', null, ['s' => \Helpers\App::maxSize()]) ?></p>
                <form method="post" action="<?php echo route('import.links.upload') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group">
                        <label for="file" class="form-label fw-bold"><?php ee('CSV File') ?> (.csv)</label>
                        <input type="file" class="form-control" name="file" id="file" accept=".csv">
                    </div>
                    <?php if($domains = \Helpers\App::domains()): ?>
                    <div class="mt-3">
                        <div class="form-group rounded input-select">
                            <label for="domain" class="form-label fw-bold"><?php ee('Domain') ?></label>
                            <select name="domain" id="domain" class="form-control border-start-0 ps-0" data-toggle="select">
                                <?php foreach($domains as $domain): ?>
                                    <option value="<?php echo $domain ?>" <?php echo user()->domain == $domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php if($redirects = \Helpers\App::redirects()): ?>
                    <div class="mt-3">
                        <div class="form-group rounded input-select">
                            <label for="type" class="form-label fw-bold"><?php ee('Redirect') ?></label>
                            <select name="type" id="type" class="form-control border-start-0 ps-0" data-toggle="select">
                                <?php foreach($redirects as $name => $redirect): ?>
                                    <optgroup label="<?php echo $name ?>">
                                    <?php foreach($redirect as $id => $name): ?>
                                        <option value="<?php echo $id ?>" <?php echo user()->defaulttype == $id ? 'selected' : '' ?>><?php echo $name ?></option>
                                    <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>         
                    <?php endif ?>                     
                    <button type="submit" class="btn btn-primary mt-3 rounded-3 px-3 py-2"><?php ee('Import') ?></button>
                </form>
            </div>
        </div>
    </div>
    <?php if($imports): ?>
    <div class="col-md-6">        
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <p class="mb-4"><strong><?php ee('Pending Job') ?></strong></p>
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <tbody>
                            <?php foreach($imports as $import): ?>
                                <tr>
                                    <td>
                                        <?php if($import->status == "1"): ?>
                                        <span class="badge bg-success"><?php ee('Completed') ?></span>
                                        <?php else: ?>
                                        <span class="badge bg-danger"><?php ee('Processing') ?></span>
                                        <?php endif ?>                                        
                                    </td>
                                    <td>
                                        <?php echo \Core\Helper::dtime($import->created_at, 'd.m.Y') ?>                                        
                                    </td>
                                    <td><?php echo $import->processed ?> / <?php echo $import->data->total ?> <?php ee('links') ?></td>
                                    <td class="text-end">
                                        <?php if(!$import->status): ?>
                                        <a class="dropdown-item text-danger" href="<?php echo route('import.cancel', [$import->id, \Core\Helper::nonce('import.cancel')]) ?>"><i data-feather="trash"></i> <?php ee('Cancel') ?></a>
                                        </ul>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
</div>