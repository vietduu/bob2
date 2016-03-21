<?php

namespace Bob\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Bob\Helper\UrlRoute;
use Bob\Model\DataMapper\UrlReferenceMapper;


class UrlRouteFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator){
		$urlReferenceMapper = $serviceLocator->getServiceLocator()->get(UrlReferenceMapper::class);
		return new UrlRoute($urlReferenceMapper);
	}	
}