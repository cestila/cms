<?php defined( 'SYSPATH' ) or die( 'No direct script access.' );

class Controller_API_Users extends Controller_System_Api {
	
	public function get_get()
	{		
		$uids = $this->param('uids');
		$fields = $this->param('fields');
		
		$users = Model_API::factory('api_user')
			->get($uids, $fields);

		$this->response($users);
	}
	
	public function get_roles()
	{
		$uid = $this->param('uid', NULL, TRUE);
		$fields = $this->param('fields');
		
		$roles = Model_API::factory('api_user_role')
			->get(NULL, $fields, $uid);
		
		$this->response($roles);
	}
}