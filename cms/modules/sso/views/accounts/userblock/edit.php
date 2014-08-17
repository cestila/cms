
<?php if(count($socials) > 0 OR $user->id == AuthUser::getId()): ?>
<div class="panel-heading">
	<span class="panel-title"><?php echo __('Social accounts'); ?></span>
</div>
<?php endif; ?>

<?php if(count($socials) > 0): ?>
<div class="panel-heading">
	<span class="panel-title"><?php echo __('Linked social accounts'); ?></span>
</div>
<div class="panel-body">
	<div class="row social-accounts-linked">
	<?php foreach($socials as $social): ?>
		<?php $linked[] = $social->provider(); ?>
		<div class="col-xs-2 text-center">
			<?php echo HTML::image($social->avatar(), array('class' => 'img-polaroid')); ?><br />
			<strong><?php echo $social->link(); ?></strong>
			<br />
			<?php echo UI::button(__('Disconnect'), array(
				'class' => 'btn btn-xs btn-warning',
				'href' => Route::get('accounts-auth')->uri(array(
					'directory' => 'oauth', 
					'controller' => $social->provider(), 
					'action' => 'disconnect'))
			)) ?>
		</div>
	<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>

<?php if($user->id == AuthUser::getId()): ?>
<div class="panel-heading">
	<span class="panel-title"><?php echo __('List of supported OAuth providers'); ?></span>
</div>
<div class="alert alert-info no-margin-vr">
	<?php echo UI::icon('lightbulb-o'); ?> <?php echo __('Binding account to an account in a social network will allow to enter the site with a single click. You can bind the account to several accounts. :settings_link', array(':settings_link' => HTML::anchor($settings_link, __('Settings')))); ?>
</div>
<div class="panel-body">
	<div class="btn-group">
		<?php foreach ($providers as $provider => $data): ?>
		<?php if(in_array($provider, $linked)) continue; ?>
		<?php echo UI::button(UI::icon($provider) . ' ' . Arr::path($params, $provider.'.name'), array(
			'class' => 'btn btn-social-'.$provider,
			'href' => Route::get('accounts-auth')->uri(array(
				'directory' => 'oauth', 
				'controller' => $provider, 
				'action' => 'connect'))
		)) ?>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>