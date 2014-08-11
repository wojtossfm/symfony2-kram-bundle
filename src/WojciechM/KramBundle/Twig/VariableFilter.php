<?php
namespace WojciechM\KramBundle\Twig;
class VariableFilter extends \Twig_Extension {
	public function getFilters() {
		return array(
				new \Twig_SimpleFilter('stringify', array($this, "apply"),
						array('pre_escape' => 'html',
								'is_safe' => array('html'))));
	}

	public function apply($variable, $format = NULL) {
		$pres = "";
		switch ($format) {
		case "date": {
				$pres = $variable->format('Y-m-d');
				break;
			}
		case "summary": {
				$user = $variable["user"];
				$amount = $variable["amount"];
				$class = ($amount < 0) ? "debt" : "paid";
				$pres = "$user: <span class=\"summary $class\">$amount</span>";
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
