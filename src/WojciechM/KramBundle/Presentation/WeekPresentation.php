<?php

namespace WojciechM\KramBundle\Presentation;
class WeekPresentation extends Presentation {
	
	public function __construct() {
		$this->fields = array(
			new PresentationField(PresentationField::$TYPE_PROP, 
				array("start", "end"), "Dates", "date"),
			new PresentationField(PresentationField::$TYPE_SINGLE, "fee", "Fee", NULL),
			new PresentationField(PresentationField::$TYPE_LIST, "summary", "Summary", "summary"),
			new PresentationField(PresentationField::$TYPE_LIST, "shoppers", "Shoppers", NULL),
			new PresentationField(PresentationField::$TYPE_LIST, "collectors", "Collectors", NULL),
			new PresentationField(PresentationField::$TYPE_LIST, "expenses", "Expenses", NULL),
		);
		$this->rowActions = array("show" => "week_show", "edit" => "week_edit",);
		$this->labels = array('plural' => 'Weeks', 'single' => 'Week');
		$this->generalActions = array("new" => "week_new");
	}

}
