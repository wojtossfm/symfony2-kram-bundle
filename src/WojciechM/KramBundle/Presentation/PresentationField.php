<?php

class PresentationField {
	public static final $TYPE_LIST = "list";
	public static final $TYPE_SINGLE = "single";
	private $type;
	private $property;
	private $label;
	private $format;

	/**
	 * @return the unknown_type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param unknown_type $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return the unknown_type
	 */
	public function getProperty() {
		return $this->property;
	}

	/**
	 * @param unknown_type $property
	 */
	public function setProperty($property) {
		$this->property = $property;
	}

	/**
	 * @return the unknown_type
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param unknown_type $label
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * @return the unknown_type
	 */
	public function getFormat() {
		return $this->format;
	}

	/**
	 * @param unknown_type $format
	 */
	public function setFormat($format) {
		$this->format = $format;
	}
	
	public function __construct($type, $property, $label, $format) {
		$this->setType($type);
		$this->setProperty($property);
		$this->setLabel($label);
		$this->setFormat($format);
	}

}
