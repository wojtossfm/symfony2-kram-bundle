<?php

namespace WojciechM\KramBundle\Presentation;
class UserPresentation extends Presentation {
	protected $fields = array(
			array("type" => "single", "property" => "username",
					"label" => "Username", "format" => NULL),
			array("type" => "single", "property" => "firstName",
					"label" => "First Name", "format" => NULL),
			array("type" => "single", "property" => "lastName",
					"label" => "Last Name", "format" => NULL),
			array("type" => "single", "property" => "isActive",
					"label" => "Active", "format" => NULL),
			array("type" => "single", "property" => "isAdmin",
					"label" => "Admin", "format" => NULL),
			array("type" => "single", "property" => "dateCreated",
					"label" => "Created", "format" => NULL),);

	protected $rowActions = array("show" => "week_show", "edit" => "week_edit",);

}
