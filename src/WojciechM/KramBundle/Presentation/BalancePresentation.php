<?php

namespace WojciechM\KramBundle\Presentation;
class BalancePresentation extends Presentation {
	
	public function __construct() {
		$this->fields = array(
			new PresentationField(PresentationField::TYPE_SINGLE, "firstName", "First Name", NULL),
			new PresentationField(PresentationField::TYPE_SINGLE, "lastName", "Last Name", NULL),
			new PresentationField(PresentationField::TYPE_SINGLE, "balance", "Balance", PresentationField::FORMAT_SUMMARY)
		);
		$this->labels = array("plural"=>"Balance sheet");
	}

}
