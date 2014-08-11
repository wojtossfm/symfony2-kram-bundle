<?php

namespace WojciechM\KramBundle\Presentation;
class WeekPresentation extends Presentation {
	protected $fields = array(
			array("type" => "properties", "property" => array("start", "end"),
					"label" => "Dates", "format" => "date"),
			array("type" => "single", "property" => "fee", "label" => "Fee",
					"format" => NULL),
			array("type" => "values", "property" => "summary",
					"label" => "Summary", "format" => "summary"),
			array("type" => "list", "property" => "shoppers",
					"label" => "Shoppers", "format" => NULL),
			array("type" => "list", "property" => "collectors",
					"label" => "Collectors", "format" => NULL),
			array("type" => "list", "property" => "expenses",
					"label" => "Expenses", "format" => NULL),);

	protected $rowActions = array("show" => "week_show", "edit" => "week_edit",);

	protected $labels = array('plural' => 'Weeks', 'single' => 'Week');

}
