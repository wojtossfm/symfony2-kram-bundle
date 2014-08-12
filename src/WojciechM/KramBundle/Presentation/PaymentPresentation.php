<?php

namespace WojciechM\KramBundle\Presentation;
class PaymentPresentation extends Presentation {
	
	public function __construct() {
		$this->fields = array(
			new PresentationField(PresentationField::$TYPE_SINGLE, "user", "User", NULL),
			new PresentationField(PresentationField::$TYPE_SINGLE, "week", "Week", NULL),
			new PresentationField(PresentationField::$TYPE_SINGLE, "type", "Type", NULL),
			new PresentationField(PresentationField::$TYPE_SINGLE, "amount", "Amount", NULL),
			new PresentationField(PresentationField::$TYPE_SINGLE, "dateCreated", "Created", PresentationField::$FORMAT_DATE),
		);
		$this->rowActions = array("edit" => "payment_edit", "delete" => "payment_delete");
		$this->labels = array('plural' => 'Payments', 'single' => 'Payment');
		$this->generalActions = array("new" => "payment_new");
	}

}
