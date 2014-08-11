<?php
namespace WojciechM\KramBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

use WojciechM\KramBundle\Controller\ExtendedController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Router;

class AuthenticationListener {
	private $container = NULL;
	
	public function __construct(Container $container) {
		$this->container = $container;
	}
	
	public function onKernelException(GetResponseForExceptionEvent $event) {
		$request = $event->getRequest();
		$exception = $event->getException();
		if (!$request->isXmlHttpRequest() || (!$exception instanceof AuthenticationException
				&& !$exception instanceof AccessDeniedException)) {
			return;
		}
		$url = $this->container->get("router")->generate("login");
		$response = ExtendedController::getAjaxRedirect($request, $url);
		$event->setResponse($response);
		$event->stopPropagation();
	}
}
