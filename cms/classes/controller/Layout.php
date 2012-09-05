<?php defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

class Controller_Layout extends Controller_System_Backend {

	public $auth_required = array( 'administrator', 'developer' );

	function action_index()
	{
		$this->template->content = View::factory( 'layout/index', array(
			'layouts' => Layout::findAll()
		) );
	}

	function action_add()
	{
		// check if trying to save
		if ( Request::current()->method() == Request::POST )
		{
			return $this->_add();
		}
		
		$this->template->breadcrumbs = array(
			HTML::anchor( 'layout', __('Layouts')),
			__('Add layout')
		);

		// check if user have already enter something
		$layout = Flash::get( 'post_data' );

		if ( empty( $layout ) )
		{
			$layout = new Layout;
		}

		$this->template->content = View::factory( 'layout/edit', array(
			'action' => 'add',
			'layout' => $layout
		) );
	}

	function _add()
	{
		$data = $_POST['layout'];
		Flash::set( 'post_data', (object) $data );

		if ( empty( $data['name'] ) )
		{
			Flash::set( 'error', __( 'You have to specify a name!' ) );
			$this->go( URL::site( 'layout/add/' ) );
		}

		$layout = new Layout( $data['name'] );
		$layout->content = $data['content'];

		if ( !$layout->save() )
		{
			Messages::errors(__( 'Layout <b>:name</b> has not been added. Name must be unique!', array( ':name' => $layout->name ) ) );

			$this->go( URL::site( 'layout/add/' ) );
		}
		else
		{
			
			Messages::success( __( 'Layout <b>:name</b> has been added!', array( ':name' => $layout->name ) ) );
			Observer::notify( 'layout_after_add', array( $layout ) );
		}

		// save and quit or save and continue editing?
		if ( isset( $_POST['commit'] ) )
		{
			$this->go( URL::site( 'layout' ) );
		}
		else
		{
			$this->go( URL::site( 'layout/edit/' . $layout->name ) );
		}
	}

	function action_edit( $layout_name )
	{
		$layout = new Layout( $layout_name );
		
		$this->template->breadcrumbs = array(
			HTML::anchor( 'layout', __('Layouts')),
			__('Edit layout :layout', array(':layout' => $layout->name))
		);

		if ( !$layout->isExists() )
		{
			Messages::errors(__( 'Layout <b>:name</b> not found!', array( ':name' => $layout->name ) ) );
			$this->go( URL::site( 'layout' ) );
		}

		// check if trying to save
		if ( Request::current()->method() == Request::POST )
		{
			return $this->_edit( $layout );
		}

		$this->template->content = View::factory( 'layout/edit', array(
			'action' => 'edit',
			'layout' => $layout
		) );
	}

	function _edit( $layout )
	{
		$layout->name = $_POST['layout']['name'];
		$layout->content = $_POST['layout']['content'];

		if ( !$layout->save() )
		{
			Messages::errors(__( 'Layout <b>:name</b> has not been saved. Name must be unique!', array( ':name' => $layout->name ) ) );
		}
		else
		{
			Messages::success(__( 'Layout <b>:name</b> has been saved!', array( ':name' => $layout->name ) ) );
			Observer::notify( 'layout_after_edit', array( $layout ) );
		}

		// save and quit or save and continue editing?
		if ( isset( $_POST['commit'] ) )
		{
			$this->go( URL::site( 'layout' ) );
		}
		else
		{
			$this->go( URL::site( 'layout/edit/' . $layout->name ) );
		}
	}

	function action_delete( $layout_name )
	{

		$this->auto_render = FALSE;

		$layout = new Layout( $layout_name );

		// find the user to delete
		if ( !$layout->isUsed() )
		{
			if ( $layout->delete() )
			{
				Messages::success( __( 'Layout <b>:name</b> has been deleted!', array( ':name' => $layout_name ) ) );
				Observer::notify( 'layout_after_delete', array( $layout_name ) );
			}
			else
			{
				Messages::errors( __( 'Layout <b>:name</b> has not been deleted!', array( ':name' => $layout_name ) ) );
			}
		}
		else
		{
			Messages::errors( __( 'Layout <b>:name</b> is used! It <i>can not</i> be deleted!', array( ':name' => $layout_name ) ) );
		}

		$this->go( URL::site( 'layout' ) );
	}

}

// end LayoutController class