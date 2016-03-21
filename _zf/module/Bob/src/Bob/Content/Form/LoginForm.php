<?php
namespace Bob\Content\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Db\Adapter\AdapterInterface;

class LoginForm extends Form 
{
	public function __construct() {
		parent::__construct('login-page');

		$this->setAttribute('method','post');

		$this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' => array(
                'label' => 'Username:',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Password:',
            ),
        ));

		$this->add(array(
             'name' => 'submit',
             'attributes' => array(
             	 'type' => 'submit',
                 'value' => 'Login',
                 'id' => 'submit_btn',
             ),
        ));
	}

	public function populateValues($data)
    {   
        foreach($data as $key=>$row)
        {
           if (is_array(@json_decode($row))){
                $data[$key] =   new \ArrayObject(\Zend\Json\Json::decode($row), \ArrayObject::ARRAY_AS_PROPS);
           }
        } 
         
        parent::populateValues($data);
    }
}