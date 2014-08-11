<?php

namespace WojciechM\KramBundle\Presentation;
class Presentation {

	protected $fields = array();
	protected $detailFields = array();
	protected $rowActions = array();
	protected $generalActions = array();
	protected $labels = array();

	public function getFields() {
		return $this->fields;
	}

	public function getRowActions() {
		return $this->rowActions;
	}
	
	public function getGeneralActions() {
		return $this->generalActions;
	}

	public function getLabels() {
		return $this->labels;
	}

}
