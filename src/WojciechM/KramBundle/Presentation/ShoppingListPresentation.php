<?php

namespace WojciechM\KramBundle\Presentation;
class ShoppingListPresentation extends Presentation {
	
	public function __construct() {
		$this->fields = array(
			new PresentationField(PresentationField::TYPE_SINGLE, "dateCreated", "Created", PresentationField::FORMAT_DATE),
			new PresentationField(PresentationField::TYPE_LIST, "entries", "Entries", NULL)
		);
		$this->rowActions = array("show" => "shoppinglist_show", "delete" => "shoppinglist_delete");
		$this->labels = array('plural' => 'Shopping Lists', 'single' => 'Shopping List');
		$this->generalActions = array();
	}

}
