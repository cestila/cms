<div id="pageEditParts">
<?php
	$index = 1;

	foreach ( $page_parts as $page_part )
	{
		echo View::factory('page/blocks/part_edit', array(
			'index' => $index,
			'page_part' => $page_part,
			'permissions' => $permissions
		));

		$index++;
	}
?>

</div>
<?php if ( AuthUser::hasPermission( array( 'administrator', 'developer' ) ) ): ?>
	<div id="pageEditPartAdd" class="widget-header widget-no-border-radius">
		<?php
		echo UI::button( __( 'Add page part' ), array(
			'id' => 'pageEditPartAddButton', 'icon' => UI::icon( 'plus' )
		) );
		?>
	</div>
<?php endif; ?>