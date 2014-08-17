<div class="map widget">
	<?php echo Form::open(NULL, array('class' => Bootstrap_Form::HORIZONTAL)); ?>
	<?php echo Form::hidden('token', Security::token()); ?>
	<div class="widget-title">
		<div class="form-group">
			<label class="control-label title"><?php echo __( 'Message title' ); ?></label>
			<div class="controls">
				<?php echo Form::input( 'title', NULL, array(
					'class' => 'input-block-level input-title focus'
				) ); ?>
			</div>
		</div>
		
		<?php if($to !== NULL): ?>
		<?php echo Form::hidden( 'to', $to ); ?>
		<?php else: ?>
		<br />
		
		<div class="form-group">
			<label class="control-label col-md-3"><?php echo __( 'Message to' ); ?></label>
			<div class="controls">
				<?php echo Form::input( 'to', Request::current()->query('to'), array(' autocomplete' => 'off', 'id' => 'messageTo') ); ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<div class="panel-body  widget-nopad">
		<?php echo Form::textarea('content', NULL, array('id' => 'message-content')); ?>
		<script>
		$(function() {
			cms.filters.switchOn( 'message-content', '<?php echo Config::get('site', 'default_filter_id'); ?>');
		});
		</script>
	</div>
	<div class="panel-footer form-actions">
		<?php echo UI::button(__('Send message'), array('class' => 'btn btn-lg')); ?>
	</div>
	<?php echo Form::close(); ?>
</div>