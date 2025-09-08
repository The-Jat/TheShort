<div class="d-flex mb-5">
	<div>
		<h1 class="mb-0 h3 fw-bold">
			<img src="<?php echo assets('images/zapier.svg') ?>" class="icon-45 border rounded-3 p-2 bg-white me-3"> <?php echo e("Zapier Integration") ?>             
			<?php if(user()->zapurl || user()->zapview): ?>
				<i class="ms-1 fa fa-check-circle fs-4 text-success" data-bs-toggle="tooltip" title="<?php ee('Connected') ?>"></i>
			<?php endif ?> 
		</h1>
	</div>
</div>
<div class="card rounded-4 shadow-sm">
	<div class="card-body">		
		<p><?php echo e("You can use Zapier to automate campaigns. By adding the URL to the zapier webhook, we will send you important information to that webhook so you can use them.") ?></p>
		<p class="border border-dark p-3 rounded-3"><strong class="me-2"><?php ee('Note') ?></strong> <?php ee('Although this tool is designed for Zapier, it can be used for any webhook system.') ?></p>
		<form action="<?php echo route("user.zapier") ?>" method="post">
			<div class="form-group">
				<label for="zapurl" class="form-label fw-bold"><?php echo e("URL Zapier Notification") ?></label>
				<input type="text" id="zapurl" name="zapurl" class="form-control p-2" placeholder="e.g. https://" value="<?php echo user()->zapurl ?>">
				<p class="form-text"><?php echo e("We will send a notification to this URL when you create a short URL.") ?></p>
			</div>
			<div class="form-group">
				<label for="zapview" class="form-label fw-bold"><?php echo e("Views Zapier Notification") ?></label>
				<input type="text" id="zapview" name="zapview" class="form-control p-2" placeholder="e.g. https://" value="<?php echo user()->zapview ?>">
				<p class="form-text"><?php echo e("We will send a notification to this URL when someone clicks your URL.") ?></p>
			</div>
			<?php echo csrf() ?>
			<button class="btn btn-primary rounded-3 px-3 py-2" type="submit"><?php echo e("Save") ?></button>
		</form>
	</div>
</div>
<h4 class="fw-bold mb-3 mt-5"><?php echo e("Sample Response") ?></h4>
<div class="card rounded-4 shadow-sm mb-0">
	<div class="card-body">	
		<p><strong><?php echo e("URL Zapier Notification") ?></strong></p>
		<pre class="hljs rounded-3 p-3"><code class="rounded-3 json"><?php echo json_encode( ["type" => "url", "longurl" => "https://google.com", "shorturl" => url('C2Rxy'), "title" => "Google", "date" => "17-05-2020 04:17:44" ], JSON_PRETTY_PRINT) ?></code></pre>

		<br>
		<p><strong><?php echo e("Views Zapier Notification") ?></strong></p>
		<pre class="hljs rounded-3 p-3 mb-0"><code class="rounded-3 json"><?php echo json_encode(["type" => "view", "shorturl" => url('C2Rxy'), "country" => "Canada", "referer" => "https://yahoo.com", "os" => "Windows", "browser" => "Chrome", "date" => "17-05-2020 04:20:19"], JSON_PRETTY_PRINT) ?></code></pre>                                  
	</div>
</div>