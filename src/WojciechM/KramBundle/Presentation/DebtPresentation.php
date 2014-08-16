<?php

namespace WojciechM\KramBundle\Presentation;
class DebtPresentation extends Presentation {
	
	public function __construct() {
		$this->fields = array(
			new PresentationField(PresentationField::TYPE_SINGLE, "user", "User", NULL),
			new PresentationField(PresentationField::TYPE_SINGLE, "week", "Week", NULL),
			new PresentationField(PresentationField::TYPE_SINGLE, "amount", "Amount", NULL),
			new PresentationField(PresentationField::TYPE_SINGLE, "dateCreated", "Created", PresentationField::FORMAT_DATE),
		);
		$this->rowActions = array("edit" => "debt_edit", "delete" => "debt_delete");
		$this->labels = array('plural' => 'Debts', 'single' => 'Debt');
		$this->generalActions = array("new" => "debt_new");
	}

}
