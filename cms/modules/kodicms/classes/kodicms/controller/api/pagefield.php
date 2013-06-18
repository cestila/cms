<?php defined( 'SYSPATH' ) or die( 'No direct script access.' );

class KodiCMS_Controller_API_Pagefield extends Controller_System_Api {
	
	public function rest_put()
	{
		$page_id = (int) $this->param('page_id', NULL, TRUE);
		$field_array = $this->param('field', NULL, TRUE);
		
		if( ! Model_Page::findById($page_id))
			throw new HTTP_API_Exception(__('Page not found'));

		$field_array['page_id'] = $page_id;
		
		$field = ORM::factory('page_field')->values($field_array);
		
		if($field->create())
		{
			$view = View::factory('page_fields/page/field', array(
				'field' => $field
			));
			
			$this->response((string) $view);
		}
	}
	
	public function rest_delete()
	{
		$field_id = (int) $this->param('field_id', NULL, TRUE);
		
		ORM::factory('page_field', $field_id)->delete();
		Messages::success(__('Page field deleted'));
	}
	
	public function rest_post()
	{
		$field_id = (int) $this->param('field_id', NULL, TRUE);
		$value = $this->param('value');

		if(ORM::factory('page_field', $field_id)->values(array(
			'value' => $value
		))->update())
		{
			Messages::success(__('Page field updated'));
		}
		
	}
	
}