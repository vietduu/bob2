<?php
namespace Bob\Content\Form;
use Zend\Form\Form;
use Zend\Form\Element;

class CmsRemovalForm extends Form 
{
	protected $adapter;

	public function __construct($id) {
		parent::__construct('cms');

		$this->setAttribute('method','post');

		$this->add(array(
			'name' => 'id_cms_folder',
			'attributes' => array(
				'type' => 'hidden',
                'value' => $id,
			),
		));

		$this->add(array(
             'name' => 'submit',
             'attributes' => array(
             	 'type' => 'submit',
                 'value' => 'Save',
                 'id' => 'submit_btn',
             ),
        ));

        $this->add(array(
             'name' => 'cancel',
             'attributes' => array(
             	 'type' => 'submit',
                 'value' => 'Cancel',
                 'id' => 'cancel_btn',
             ),
        ));
	}
}