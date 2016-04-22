<?php
namespace Bob\Content\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Db\Adapter\AdapterInterface;

class PetDetailForm extends Form 
{
	protected $adapter;

	public function __construct(AdapterInterface $adapter) {
		parent::__construct('pet-detail-page');
		$this->adapter = $adapter;

		$this->setAttribute('method','post');

		$this->add(array(
			'name' => 'product_type',
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Loại sản phẩm:',
				'empty_option' => 'Please select...',
				'value_options' => $this->getAllProductTypes(),
			)
		));

        $this->add(array(
            'name' => 'invoice_type',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Loại hóa đơn:',
                'empty_option' => 'Please select...',
                'value_options' => $this->getAllInvoiceTypes(),
            )
        ));

        for ($i = 0; $i < count($this->getAllAttributeTypes()); $i++){
            $this->add(array(
                'name' => $this->getAllAttributeTypes()[$i],
                'type' => 'Text',
                'options' => array(
                    'label' => $this->getAllAttributeTypes()[$i] . ":",
                    'place_holder' => 'Please select...',
                )
            ));
        }

		$this->add(array(
             'name' => 'submit',
             'attributes' => array(
             	 'type' => 'submit',
                 'value' => 'Create',
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

    public function getAllProductTypes(){
    	$adapter = $this->adapter;
    	$sql = "SELECT * FROM product_type";
    	$statement = $adapter->query($sql);
        $result    = $statement->execute();
        $types 	   = $result->getResource()->fetchAll();

        $selectData = array();
        foreach ($types as $type) {
            $selectData[] = $type[1];
        }

        return $selectData;
    }

    public function getAllInvoiceTypes(){
        $adapter = $this->adapter;
        $sql = "SELECT * FROM invoice_type";
        $statement = $adapter->query($sql);
        $result    = $statement->execute();
        $types     = $result->getResource()->fetchAll();

        $selectData = array();
        foreach ($types as $type) {
            $selectData[] = $type[1];
        }

        return $selectData;
    }

    public function getAllAttributeTypes(){
        $adapter = $this->adapter;
        $sql = "SELECT * FROM attribute_type";
        $statement = $adapter->query($sql);
        $result    = $statement->execute();
        $types     = $result->getResource()->fetchAll();

        $selectData = array();
        foreach ($types as $type) {
            $selectData[] = $type[2];
        }

        return $selectData;
    }
}