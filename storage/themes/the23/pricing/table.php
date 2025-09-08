<div class="card border-0 rounded-lg shadow-sm text-center p-4 py-5 table-responsive my-5">
	<table class="table border-0 w-fixed">
		<thead>
			<th width="20%"></th>
			<?php $count = count($plans); foreach($plans as $plan): ?>
				<th width="<?php echo round(80/($count)) ?>%"></th>
			<?php endforeach ?>
		</thead>
		<tbody>
			<tr>
				<td>&nbsp;</td>
				<?php foreach($plans as $plan): ?>
					<td>
						<?php if($plan['ispopular']): ?>
							<span class="px-3 py-1">
								<span class="fw-bold badge bg-info py-1 px-3 fs-6"><?php ee('Popular') ?></span>
							</span>  
						<?php endif ?> 												
						<?php if(isset($plan['discount']) && $plan['discount']): ?>
							<span data-toggle="discount" class="d-none px-3 py-1">
								<span class="fw-bold badge bg-success py-1 px-3 fs-6"><?php ee('Save {p}%', null, ['p' => $plan['discount'] ]) ?></span>
							</span>
						<?php endif ?>				
						<?php if($plan['icon']): ?>
                        	<span class="fs-1 mb-3 d-block"><i class="<?php echo $plan['icon'] ?>"></i></span>
						<?php endif ?>
						<span class="d-block h5 mb-4 mt-3 fw-bold"><?php ee($plan['name']) ?></span>
						<div class="h3 text-center mb-0 fw-bolder gradient-primary clip-text" data-pricing-monthly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_monthly"]) ?>" data-pricing-yearly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_yearly"]) ?>" data-pricing-lifetime="<?php echo  $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_lifetime"]) ?>"><strong><span class="price"><?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_".$default]) ?></span><?php echo $plan['free'] ? '' : '<small data-toggle="pricingterm" data-term-monthly="/'.e('month').'" data-term-yearly="/'.e('year').'" data-term-lifetime="'.e('lifetime').'" class="fs-6">'.$term.'</small>' ?></strong></div>
						<?php echo $plan['description'] ? '<span class="d-block mt-3">'.e($plan['description']).'</span>': '' ?>
						<?php if($plan['planurl'] == "#"):?>
							<a href="<?php echo route('billing') ?>" class="btn bg-secondary my-3 py-2 btn-sm d-block mx-3 fw-bolder"><strong><?php echo $plan['plantext'] ?></strong></a>
						<?php else: ?>
							<a href="<?php echo $plan['planurl'] ?>" class="btn btn-primary my-3 py-2 btn-sm d-block mx-3" data-trigger="checkout"><?php echo $plan['plantext'] ?></a>
						<?php endif?>
					</td>
				<?php endforeach ?>
			</tr>
			<tr>
				<td class="py-3 text-start fw-bold"><?php ee('Short Links') ?> <i class="align-middle fa fa-question-circle opacity-50 text-muted small ms-2" data-bs-toggle="tooltip" title="<?php ee('Number of short links allowed') ?>"></i></td>
				<?php foreach($plans as $plan): ?>
				<td class="py-3 fw-bold">
					<?php echo $plan['urls'] == '0' ? '<i class="align-middle fa fa-infinity gradient-primary clip-text"></i>' : number_format($plan['urls']).($plan['ismonthly'] ? ' / '.e('month') : '') ?>
				</td>
				<?php endforeach ?>
			</tr>
			<tr>
				<td class="py-3 text-start fw-bold"><?php ee('Link Clicks') ?> <i class="align-middle fa fa-question-circle opacity-50 text-muted small ms-2" data-bs-toggle="tooltip" title="<?php ee('Total clicks allowed over a period') ?>"></i></td>
				<?php foreach($plans as $plan): ?>
				<td class="py-3 fw-bold">
					<?php echo $plan['clicks'] == '0' ? '<i class="align-middle fa fa-infinity gradient-primary clip-text"></i>' : number_format($plan['clicks']).' / '.e('month') ?>
				</td>
				<?php endforeach ?>
			</tr>
			<tr>
				<td class="py-3 text-start fw-bold"><?php ee('Data Retention') ?> <i class="align-middle fa fa-question-circle opacity-50 text-muted small ms-2" data-bs-toggle="tooltip" title="<?php ee('Amount of time statistics are kept for each short link.') ?>"></i></td>
				<?php foreach($plans as $plan): ?>
				<td class="py-3 fw-bold">
					<?php echo $plan['retention'] == '0' ? e('Forever') : $plan['retention'].' '.e('days') ?>
				</td>
				<?php endforeach ?>
			</tr>
			<?php if($features = \Helpers\App::features()): ?>
				<?php foreach($features as $slug => $feature): ?>
					<tr>
						<td class="py-3 text-start fw-bold">
							<?php echo $feature['name'] ?> 
							<i class="align-middle fa fa-question-circle opacity-50 text-muted small ms-2" data-bs-toggle="tooltip" title="<?php echo $feature['description'] ?>"></i>
						</td>
						<?php foreach($plans as $plan): ?>
							<td>
								<?php 
								$featureEnabled = isset($plan["permission"]->{$slug}) && $plan["permission"]->{$slug}->enabled;
								if(!$featureEnabled): ?>
									<i class="align-middle fa fa-times text-danger"></i>
								<?php else:
									// Handle feature with count
									if($feature['count']): 
										$count = $plan["permission"]->{$slug}->count;
										if($slug === 'apirate'): ?>
											<span class="fw-bolder">
												<?php echo $count == '0' ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : ee('{x}/min', null, ['x' => $count]); ?>
											</span>
										<?php else: ?>
											<?php if($count == '0'): ?>
												<i class="align-middle fa fa-infinity gradient-primary clip-text"></i>
											<?php else: ?>
												<strong><?php echo $count ?></strong>
												<?php if($slug == 'qr' && $plan['isqrmonthly']): ?>
													<strong>/ <?php ee('month') ?></strong>
												<?php endif ?>
											<?php endif ?>
										<?php endif ?>
									<?php elseif($slug === 'bioblocks'): ?>
										<span class="gradient-primary clip-text fw-bold">
											<?php 
											$blockCount = !empty($plan["permission"]->bioblocks->custom) 
												? count(explode(',', $plan["permission"]->bioblocks->custom)) 
												: count(\Helpers\BioWidgets::widgets());
											echo $blockCount . ' ' . e('Widgets');
											?>
										</span>
									<?php else: ?>
										<i class="align-middle fa fa-check text-success"></i>
									<?php endif ?>
								<?php endif ?>
							</td>
						<?php endforeach ?>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
			<tr>
				<td class="py-3 text-start fw-bold"><?php ee('Advertisement-Free') ?> <i class="align-middle fa fa-question-circle opacity-50 text-muted small ms-2" data-bs-toggle="tooltip" title="<?php ee('No advertisement will be shown when logged or in your links') ?>"></i></td>
				<?php foreach($plans as $plan): ?>
				<td class="py-3 fw-bold">
					<?php echo !$plan["free"]  ? '<i class="align-middle fa fa-check text-success"></i>' : '<i class="align-middle fa fa-times text-danger"></i>' ?>
				</td>
				<?php endforeach ?>
			</tr>
			<tr class="border-0">
				<td>&nbsp;</td>
				<?php foreach($plans as $plan): ?>
					<td class="py-3">
						<?php if(isset($plan["permission"]->custom)): ?>
							<?php echo $plan["permission"]->custom ?>
						<?php endif ?>
					</td>
				<?php endforeach ?>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<?php foreach($plans as $plan): ?>
					<td>
						<?php if($plan['planurl'] == "#"):?>
							<a href="<?php echo route('billing') ?>" class="btn bg-secondary my-3 d-block py-2 mx-3 fw-bolder"><strong><?php echo $plan['plantext'] ?></strong></a>
						<?php else: ?>
							<a href="<?php echo $plan['planurl'] ?>" class="btn btn-primary my-3 d-block py-2 mx-3" data-trigger="checkout"><?php echo $plan['plantext'] ?></a>
						<?php endif?>
					</td>
				<?php endforeach ?>
			</tr>
		</tbody>
	</table>
</div>