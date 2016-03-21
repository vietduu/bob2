<?php
namespace Bob\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Bob\Helper\ServiceConfigHelper;
use Bob\Helper\ConcreteServiceConfig;
use Bob\Content\Form\LoginForm;
use Bob\Model\DataObject\AclUser;

class IndexController extends AbstractActionController
{
	public function indexAction(){
		$view = new ViewModel();

		$form = new LoginForm();
		$form->get('submit')->setValue('Login');

		$request = $this->getRequest();

		if ($request->isPost()) {
			$aclUser = new AclUser();
			$form->setInputFilter($aclUser->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()){
				$aclUser = $form->getData();
				$authen = $this->authenticateUser($aclUser['username'], $aclUser['password']);
				if (-1 == $authen){
					$view->errorMessage = 'This user doesn\'t exist.';
				} else if (0 == $authen){
					$view->errorMessage = 'Wrong password.';
				} else if (1 == $authen){
					$view->errorMessage = '';
					return $this->redirect()->toRoute('pet');
				}
			}
		}

		$view->form = $form;
		return $view;
	}

	public function petAction()
	{
		$view = new ViewModel(array(
			'all_product_types' => $this->fetchAllProductTypes(),
			'product_type' => $this->getProductType(1),
			'all_general_products' => $this->fetchAllGeneralProducts(),
			'products_by_type_id' => $this->getProductsByProductTypeId(1),
			'product_info' => $this->getFullInformationByTypeId(1),
			'all_invoice_types' => $this->fetchAllInvoiceTypes(),
			'products_by_invoice_type' => $this->getProductInformationByInvoiceId(2),
			));
		return $view;
	}

	public function productAction()
	{
		$view = new ViewModel();
		$request = $this->getRequest();
		$url = $request->getUri();
		$params = substr($url, strripos($url,'/')+1);
		$product_id = substr($params, 0, -5);
		$view->product_id = $product_id;
		$product_info = $this->getFullInformationById($product_id);
		$view->currentProduct = $product_info;
		$images = $this->getImagesFromProductId($product_id);
		$view->images = $images;
		$view->all_product_types = $this->fetchAllProductTypes();
		$view->invoiceType = $this->fetchAllInvoiceTypes();

		return $view;
	}

	public function getFullInformationById($id)
	{
		$productById = ConcreteServiceConfig::getGeneralProductServiceConfig($this);
		$_id = (int) $id;
		return $productById->getFullInformationById($_id);
	}

	public function getProductType($id)
	{
		$productTypeMapper = ConcreteServiceConfig::getProductTypeServiceConfig($this);
		
		$_id = (int) $id;
		return $productTypeMapper->getById($_id);
	}

	public function fetchAllProductTypes()
	{
		$products = ConcreteServiceConfig::getProductTypeServiceConfig($this);
		return $products->fetchAll();
	}



	public function fetchAllGeneralProducts()
	{
		$general_products = ConcreteServiceConfig::getGeneralProductServiceConfig($this);
		return $general_products->fetchAll();
	}

	public function getProductsByProductTypeId($id)
	{
		$products = ConcreteServiceConfig::getGeneralProductServiceConfig($this);
		return $products->getProductsByProductTypeId($id);
	}

	public function getFullInformationByTypeId($id)
	{
		$product = ConcreteServiceConfig::getGeneralProductServiceConfig($this);
		return $product->getFullInformationByTypeId($id);
	}

	public function fetchAllInvoiceTypes()
	{
		$invoice_types = ConcreteServiceConfig::getInvoiceTypeServiceConfig($this);
		return $invoice_types->fetchAll();
	}

	public function getProductInformationByInvoiceId($id)
	{
		$products = ConcreteServiceConfig::getGeneralProductServiceConfig($this);
		return $products->getProductInformationByInvoiceTypeId($id);
	}

	public function getImagesFromProductId($id)
	{
		$images = ConcreteServiceConfig::getImagesServiceConfig($this);
		return $images->getImagesFromProductId($id);
	}

	public function authenticateUser($name, $pwd){
		$user = ConcreteServiceConfig::getAclServiceConfig($this);
		return $user->authenticateUser($name, $pwd);
	}
}