<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Cron Jobs') ?></li>
  </ol>
</nav>
<div class="d-flex align-items-center mb-5">
    <div>
        <h1 class="h3 mb-2 fw-bold"><?php ee('Cron Jobs') ?></h1>
        <p class="mb-0 ms-auto"><?php ee('You need to add the following cron jobs either through cPanel (or other control panel) or directly to your server cron jobs.') ?></p>
    </div>
    <div class="ms-auto">
        <a href="<?php echo route('admin.crons.clear') ?>" class="btn btn-danger rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Clear Logs') ?></a>
    </div>
</div>
<?php if(\Helpers\App::possible()): ?>
<div class="row">
    <div class="col-md-6 h-100">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('User Membership') ?></div>
            <div class="card-body">
                <div class="form-group mb-2">
                    <p><?php ee('This cron will check all users and if they are expired, it will switch them to a free plan') ?></p>

                    <label for="date" class="form-label fw-bold"><?php ee('Cron Link') ?></label>
                    <input type="text" class="form-control" value="<?php echo route('crons.user', [md5('user'.AuthToken)]) ?>" disabled>
                </div>
                <p class="mt-3"><?php ee('Cron Command') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">wget -q -O - <?php echo route('crons.user', [md5('user'.AuthToken)]) ?> >/dev/null 2>&1</pre>

                <p class="mt-3"><?php ee('The following command line will run every day at midnight. You can change it as per your needs.') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">0 0 * * * wget -q -O - <?php echo route('crons.user', [md5('user'.AuthToken)]) ?> >/dev/null 2>&1</pre>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Logs') ?></div>
            <div class="card-body">
                <textarea rows="15" class="form-control w-100"><?php echo file_exists(LOGS.'/Cron.users.log') ? file_get_contents(LOGS.'/Cron.users.log') : 'Log not found' ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 h-100">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Remind Trial Users') ?></div>
            <div class="card-body">
                <div class="form-group mb-2">
                    <p><?php ee('This cron will check all trial users and if they are close to expiry, it will remind them to renew. The number of days is defined in the cron url. In the urls below, it is currently set to 1 so this means users will be reminded if their trial expires in 1 day.') ?></p>

                    <label for="date" class="form-label fw-bold"><?php ee('Cron Link') ?></label>
                    <input type="text" class="form-control" value="<?php echo route('crons.remind', ['1', md5('remind'.AuthToken)]) ?>" disabled>
                </div>
                <p class="mt-3"><?php ee('Cron Command') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">wget -q -O - <?php echo route('crons.remind', ['1', md5('remind'.AuthToken)]) ?> >/dev/null 2>&1</pre>

                <p class="mt-3"><?php ee('The following command line will run every day at midnight. You can change it as per your needs.') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">0 0 * * * wget -q -O - <?php echo route('crons.remind', ['1', md5('remind'.AuthToken)]) ?> >/dev/null 2>&1</pre>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Logs') ?></div>
            <div class="card-body">
                <textarea rows="15" class="form-control w-100"><?php echo file_exists(LOGS.'/Cron.reminded.log') ? file_get_contents(LOGS.'/Cron.reminded.log') : 'Log not found' ?></textarea>
            </div>
        </div>
    </div>
</div>
<?php endif ?>
<div class="row">
    <div class="col-md-6 h-100">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <div class="form-group mb-2">
                    <label for="date" class="form-label fw-bold"><?php ee('Data Retention') ?></label>
                    <p><?php ee('This cron will remove data with respect to the data retention settings in the plan.') ?></p>
                    <input type="text" class="form-control" value="<?php echo route('crons.data', [md5('data'.AuthToken)]) ?>" disabled>
                </div>
                <p class="mt-3"><?php ee('Cron Command') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">wget -q -O - <?php echo route('crons.data', [md5('data'.AuthToken)]) ?> >/dev/null 2>&1</pre>

                <p class="mt-3"><?php ee('The following command line will run every day at midnight. You can change it as per your needs.') ?></p>
                <pre class="bg-dark text-white p-3 rounded my-3">0 0 * * * wget -q -O - <?php echo route('crons.data', [md5('data'.AuthToken)]) ?> >/dev/null 2>&1</pre>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Logs') ?></div>
            <div class="card-body">
                <textarea rows="15" class="form-control w-100"><?php echo file_exists(LOGS.'/Cron.data.log') ? file_get_contents(LOGS.'/Cron.data.log') : 'Log not found' ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 h-100">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <div class="form-group mb-2">
                    <label for="date" class="form-label fw-bold"><?php ee('URL Checks') ?> (Optional)</label>
                    <p><?php ee('This cron will check each URL in the database against active security checks like Web Risk, Phishtank, Virus Total or Blacklist.') ?></p>
                    <div class="alert bg-danger p-3 text-white rounded">
                        <?php ee('Using this cron job will be expensive for services like Web Risk or Virus Total as each check will count as a request and some services charge per request. Use it at your own risk.') ?>
                    </div>
                    <input type="text" class="form-control" value="<?php echo route('crons.urls', [md5('url'.AuthToken)]) ?>" disabled>

                    <p class="mt-3"><?php ee('Cron Command') ?></p>
                    <pre class="bg-dark text-white p-3 rounded my-3">wget -q -O - <?php echo route('crons.urls', [md5('url'.AuthToken)]) ?> >/dev/null 2>&1</pre>

                    <p class="mt-3"><?php ee('The following command line will run every day at midnight. You can change it as per your needs.') ?></p>
                    <pre class="bg-dark text-white p-3 rounded my-3">0 0 * * * wget -q -O - <?php echo route('crons.urls', [md5('url'.AuthToken)]) ?> >/dev/null 2>&1</pre>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Logs') ?></div>
            <div class="card-body">
                <textarea rows="15" class="form-control w-100"><?php echo file_exists(LOGS.'/Cron.urls.log') ? file_get_contents(LOGS.'/Cron.urls.log') : 'Log not found' ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 h-100">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <div class="form-group mb-2">
                    <label for="date" class="form-label fw-bold"><?php ee('Import Links') ?></label>
                    <p><?php ee('Users can now upload CSV files as a part of the plan. The script will import links in the background if the CSV file contains more than 100 links for performance reasons. You need to run this cron every 30 seconds or minute so it can process the queue faster.') ?></p>

                    <input type="text" class="form-control" value="<?php echo route('crons.imports', [md5('import'.AuthToken)]) ?>" disabled>

                    <p class="mt-3"><?php ee('Cron Command') ?></p>
                    <pre class="bg-dark text-white p-3 rounded my-3">wget -q -O - <?php echo route('crons.imports', [md5('import'.AuthToken)]) ?> >/dev/null 2>&1</pre>

                    <p class="mt-3"><?php ee('The following command line will run every minute. You can change it as per your needs.') ?></p>
                    <pre class="bg-dark text-white p-3 rounded my-3">* * * * * wget -q -O - <?php echo route('crons.imports', [md5('import'.AuthToken)]) ?> >/dev/null 2>&1</pre>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Logs') ?></div>
            <div class="card-body">
                <textarea rows="15" class="form-control w-100"><?php echo file_exists(LOGS.'/Cron.imports.log') ? file_get_contents(LOGS.'/Cron.imports.log') : 'Log not found' ?></textarea>
            </div>
        </div>
    </div>
</div>