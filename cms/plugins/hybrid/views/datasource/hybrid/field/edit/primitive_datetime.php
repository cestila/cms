<div class="form-group">
	<label class="control-label col-md-3" for="primitive_default"><?php echo __( 'Default value' ); ?></label>
	<div class="col-md-9">
		<?php
		echo Form::input( 'default', $field->default, array(
			'class' => 'datetimepicker', 
			'id' => 'primitive_default',
			'size' => 10,
			'autocomplete' => 'off'
		) );
		?>
	</div>
</div>

<hr />
<div class="form-group">
	<div class="col-md-9">
		<label class="checkbox"><?php echo Form::checkbox('set_current', 1, $field->set_current == 1, array('id' => 'set_current' )); ?> <?php echo __('Current datetime'); ?></label>
	</div>
</div>