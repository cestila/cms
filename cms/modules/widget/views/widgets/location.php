<script>
	var BLOCKS = <?php echo json_encode($blocks); ?>;
</script>
<div class="widget">
	<?php echo Form::open(Request::current()->uri()); ?>
	<div class="widget-content widget-no-border-radius">
		<table class="table table-striped">
			<colgroup>
				<col width="130px" />
				<col width="50px" />
				<col />
			</colgroup>
			<tbody>
				<?php echo recurse_pages($pages, 0, $blocks, $page_widgets, $pages_widgets); ?>
			</tbody>
		</table>
	</div>

	<div class="widget-footer form-actions">
		<?php echo UI::button( __('Save locations'), array(
			'icon' => UI::icon( 'plus'), 'class' => 'btn btn-large'
		)); ?>
	</div>
	<?php echo Form::close(); ?>
</div>
<?php 
function recurse_pages( $pages, $spaces = 0, $blocks = array(), $page_widgets = array(), $pages_widgets = array() ) 
{
	$data = '';
	foreach ($pages as $page)
	{
		// Выбираем из всех блоков, для шаблона текущей страницы
		$current_page_blocks = isset($blocks[$page['layout_file']]) 
				? $blocks[$page['layout_file']] 
				: array();
		
		// Исключаем из списка блоки, занятые другими виджетами
		if(!empty($pages_widgets[$page['id']]) AND is_array($current_page_blocks))
		{
			$current_page_blocks = array_diff($current_page_blocks, $pages_widgets[$page['id']]);
		}

		// Блок
		$current_block = isset($page_widgets[$page['id']]) 
				? $page_widgets[$page['id']] 
				: NULL;
		
		$data .= '<tr data-id="'.$page['id'].'">';
		$data .= '<td>';
		$data .= Form::select('blocks[' . $page['id'] . ']', $current_page_blocks, $current_block );
		$data .= '</td></td><td>';
		$data .= '<th>' . str_repeat('- ', $spaces) . $page['title'] . '</th>';
		$data .= '</tr>';
		
		if(!empty($page['childs']))
		{
			$data .= recurse_pages($page['childs'], $spaces + 5, $blocks, $page_widgets, $pages_widgets);
		}
	}
	return $data;
} 
?>