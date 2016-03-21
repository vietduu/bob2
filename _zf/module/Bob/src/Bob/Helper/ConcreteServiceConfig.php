<?php

namespace Bob\Helper;
use Bob\Helper\ServiceConfigHelper;

class ConcreteServiceConfig
{
	public static function getGeneralProductServiceConfig($owner)
	{
		return ServiceConfigHelper::getServiceConfig($owner,
			'Bob\Model\DataObject\GeneralProduct',
			'general_product',
			'Bob\Model\DataMapper\GeneralProductMapper'
			);
	}

	public static function getInvoiceTypeServiceConfig($owner)
	{
		return ServiceConfigHelper::getServiceConfig($owner,
			'Bob\Model\DataObject\InvoiceType',
			'invoice_type',
			'Bob\Model\DataMapper\InvoiceTypeMapper');
	}

	public static function getProductTypeServiceConfig($owner){
		return ServiceConfigHelper::getServiceConfig($owner,
			'Bob\Model\DataObject\ProductType',
			'product_type',
			'Bob\Model\DataMapper\ProductTypeMapper');
	}

	public static function getImagesServiceConfig($owner){
		return ServiceConfigHelper::getServiceConfig($owner,
			'Bob\Model\DataObject\Images',
			'images',
			'Bob\Model\DataMapper\ImagesMapper');
	}

	// CMS
	public static function getCmsFolderServiceConfig($owner){
		return ServiceConfigHelper::getServiceConfig($owner,
			'Bob\Model\DataObject\CmsFolder',
			'cms_folder',
			'Bob\Model\DataMapper\CmsFolderMapper');
	}

	public static function getCmsFolderTypeServiceConfig($owner){
		return ServiceConfigHelper::getServiceConfig($owner,
			'Bob\Model\DataObject\CmsFolderType',
			'cms_folder_type',
			'Bob\Model\DataMapper\CmsFolderTypeMapper');
	}

	public static function getCmsItemServiceConfig($owner){
		return ServiceConfigHelper::getServiceConfig($owner,
			'Bob\Model\DataObject\CmsItem',
			'cms_item',
			'Bob\Model\DataMapper\CmsItemMapper');
	}

	public static function getCmsItemTypeServiceConfig($owner){
		return ServiceConfigHelper::getServiceConfig($owner,
			'Bob\Model\DataObject\CmsItemType',
			'cms_item_type',
			'Bob\Model\DataMapper\CmsItemTypeMapper');
	}

	public static function getAclServiceConfig($owner){
		return ServiceConfigHelper::getServiceConfig($owner,
			'Bob\Model\DataObject\AclUser',
			'acl_user',
			'Bob\Model\DataMapper\AclUserMapper');
	}
}