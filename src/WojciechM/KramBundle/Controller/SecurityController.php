<?php
namespace WojciechM\KramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityController extends Controller {
	public function loginAction(Request $request)
	{
		$session = $request->getSession();

		// get the login error if there is one
		if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(
					SecurityContextInterface::AUTHENTICATION_ERROR
			);
		} elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
			$error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
			$session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
		} else {
			$error = '';
		}

		// last username entered by the user
		$lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

		return $this->render(
				'WojciechMKramBundle:Default:login.html.twig',
				array(
						// last username entered by the user
						'last_username' => $lastUsername,
						'error'         => $error,
				)
		);
	}
}