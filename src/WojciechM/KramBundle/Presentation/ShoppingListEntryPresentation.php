<?php

namespace WojciechM\KramBundle\Presentation;
class ShoppingListEntryPresentation extends Presentation {
	
	public function __construct() {
		$this->fields = array(
			new PresentationField(PresentationField::TYPE_SINGLE, "name", "Name", NULL),
			new PresentationField(PresentationField::TYPE_SINGLE, "voters", "Votes", PresentationField::FORMAT_COUNT),
		);
		$this->rowActions = array("vote"=>"shopping_widget_vote", "delete"=>"shopping_widget_delete");
		$this->labels = array('plural' => 'Shopping List Entries', 'single' => 'Shopping List Entry');
		$this->generalActions = array("close"=>"shopping_widget_report");
	}

}
