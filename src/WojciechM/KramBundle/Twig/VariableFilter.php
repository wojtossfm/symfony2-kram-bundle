<?php
namespace WojciechM\KramBundle\Twig;

use WojciechM\KramBundle\Presentation\PresentationField;

class VariableFilter extends \Twig_Extension {
	public function getFilters() {
		return array(
				new \Twig_SimpleFilter('stringify', array($this, "apply"),
						array('pre_escape' => 'html', 'is_safe' => array('html'))));
	}

	public function apply($variable, $format = NULL) {
		$pres = "";
		switch ($format) {
		case PresentationField::FORMAT_COUNT: {
				$pres = count($variable);
				break;
			}
		case PresentationField::FORMAT_DATE: {
				$pres = $variable->format('Y-m-d');
				break;
			}
		case PresentationField::FORMAT_SUMMARY: {
				$class = ($variable < 0) ? "debt" : "paid";
				$pres = "<span class=\"summary $class\">$variable</span>";
				break;
			}
		default: {
				$pres = $variable;
			}
		}
		return $pres;
	}

	public function getName() {
		return 'wojciech_m_kram.twig.variable_filter';
	}
}
