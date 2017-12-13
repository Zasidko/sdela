<div class="w2dc-content">
	<?php w2dc_renderMessages(); ?>
	
	<?php if (w2dc_is_woo_packages()): ?>
	<div class="w2dc-pull-left">
		<h3><?php printf(__("Submit one single %s", "W2DC"), $directory->single); ?></h3>
	</div>
	<div class="w2dc-submit-section-adv w2dc-pull-right">
		<a href="<?php echo w2dc_submitUrl(array('listings_packages' => 1, 'directory' => $directory->id)); ?>" class="w2dc-btn w2dc-btn-primary"><?php _e('Or select a Package &rarr;', 'W2DC'); ?></a>
	</div>
	<div class="clear_float"></div>
	<?php endif; ?>
	
	<div class="w2dc-submit-section-adv">
		<?php $max_columns_in_row = $frontend_controller->args['columns']; ?>
		<?php $levels_counter = count($frontend_controller->levels); ?>
		<?php if ($levels_counter > $max_columns_in_row) $levels_counter = $max_columns_in_row; ?>
		<?php $cols_width = floor(12/$levels_counter); ?>
		<?php $cols_width_percents = (100-1)/$levels_counter; ?>

		<?php $counter = 0; ?>
		<?php $tcounter = 0; ?>
		<?php foreach ($frontend_controller->levels AS $level): ?>
		<?php $tcounter++; ?>
		<?php if ($counter == 0): ?>
		<div class="w2dc-row" style="text-align: center;">
		<?php endif; ?>

			<div class="w2dc-col-sm-<?php echo $cols_width; ?> w2dc-plan-column" style="width: <?php echo $cols_width_percents; ?>%;">
				<div class="w2dc-panel w2dc-panel-default w2dc-text-center w2dc-choose-plan">
					<div class="w2dc-panel-heading <?php if ($level->featured): ?>w2dc-featured<?php endif; ?>">
						<h3>
							<?php echo $level->name; ?>
						</h3>
						<?php if ($level->description): ?><a class="w2dc-hint-icon" href="javascript:void(0);" data-content="<?php echo esc_attr(nl2br($level->description)); ?>" data-html="true" rel="popover" data-placement="bottom" data-trigger="hover"></a><?php endif; ?>
					</div>
					<ul class="w2dc-list-group">
						<?php do_action('w2dc_submitlisting_levels_rows', $level, '<li class="w2dc-list-group-item">', '</li>'); ?>
						<?php w2dc_renderTemplate(array(W2DC_FSUBMIT_TEMPLATES_PATH, 'level_details.tpl.php'), array('args' => $frontend_controller->args, 'level' => $level)); ?>
						<?php if (!empty($w2dc_instance->submit_pages_all)): ?>
						<li class="w2dc-list-group-item">
							<a href="<?php echo w2dc_submitUrl(array('level' => $level->id, 'directory' => $directory->id)); ?>" class="w2dc-btn w2dc-btn-primary"><?php _e('Submit', 'W2DC'); ?></a>
						</li>
						<?php endif; ?>
					</ul>
				</div>          
			</div>

		<?php $counter++; ?>
		<?php if ($counter == $max_columns_in_row || $tcounter == $levels_counter): ?>
		</div>
		<?php endif; ?>
		<?php if ($counter == $max_columns_in_row) $counter = 0; ?>
		<?php endforeach; ?>
	</div>
</div>