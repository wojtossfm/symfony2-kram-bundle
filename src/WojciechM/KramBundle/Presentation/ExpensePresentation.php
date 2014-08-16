<?php

namespace WojciechM\KramBundle\Presentation;
class ExpensePresentation extends Presentation {
	
	public function __construct() {
		$this->fields = array(
			new PresentationField(PresentationField::TYPE_SINGLE, "week", "Week", NULL),
			new PresentationField(PresentationField::TYPE_SINGLE, "amount", "Amount", NULL),
			new PresentationField(PresentationField::TYPE_SINGLE, "dateCreated", "Created", PresentationField::FORMAT_DATE),
			new PresentationField(PresentationField::TYPE_SINGLE, "comment", "Comment", NULL),
		);
		$this->rowActions = array("edit" => "expense_edit", "delete" => "expense_delete");
		$this->labels = array('plural' => 'Expenses', 'single' => 'Expense');
		$this->generalActions = array("new" => "expense_new");
	}

}
