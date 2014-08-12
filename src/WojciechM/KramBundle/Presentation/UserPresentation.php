<?php

namespace WojciechM\KramBundle\Presentation;
class UserPresentation extends Presentation {
	
	public function __construct() {
		$this->fields = array(
			new PresentationField(PresentationField::$TYPE_SINGLE, "username", "Username", NULL),
			new PresentationField(PresentationField::$TYPE_SINGLE, "firstName", "First Name", NULL),
			new PresentationField(PresentationField::$TYPE_SINGLE, "lastName", "Last Name", NULL),
			new PresentationField(PresentationField::$TYPE_SINGLE, "isActive", "Active", NULL),
			new PresentationField(PresentationField::$TYPE_SINGLE, "isAdmin", "Admin", NULL),
			new PresentationField(PresentationField::$TYPE_SINGLE, "dateCreated", 
				"Created", PresentationField::$FORMAT_DATE),);
		$this->rowActions = array("show" => "user_show", "edit" => "user_edit",);
		$this->labels = array('plural' => 'Users', 'single' => 'User');
		$this->generalActions = array("new" => "user_new");
	}

}
