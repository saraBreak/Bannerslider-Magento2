<?php

/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Bannerslider
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace Magestore\Bannerslider\Model;

use Magestore\Bannerslider\Model\ResourceModel\Value\CollectionFactory as ValueCollectionFactory;

/**
 * Value Model
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Value extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var ValueCollectionFactory
     */
    protected $valueCollectionFactory;

    /**
     * Value constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ResourceModel\Value $resource
     * @param ResourceModel\Value\Collection $resourceCollection
     * @param ValueCollectionFactory $valueCollectionFactory
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magestore\Bannerslider\Model\ResourceModel\Value $resource,
        \Magestore\Bannerslider\Model\ResourceModel\Value\Collection $resourceCollection,
        ValueCollectionFactory $valueCollectionFactory
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );

        $this->valueCollectionFactory = $valueCollectionFactory;
    }

    /**
     * load attribute value.
     *
     * @param int    $bannerId
     * @param int    $storeViewId
     * @param string $attributeCode
     *
     * @return $this
     */
//    public function loadAttributeValue($bannerId, $storeViewId, $attributeCode)
//    {
//        $attributeValue = $this->getResourceCollection()
//            ->addFieldToFilter('banner_id', $bannerId)
//            ->addFieldToFilter('store_id', $storeViewId)
//            ->addFieldToFilter('attribute_code', $attributeCode)
//            ->setPageSize(1)->setCurPage(1)
//            ->getFirstItem();
//
//        $this->setData('banner_id', $bannerId)
//            ->setData('store_id', $storeViewId)
//            ->setData('attribute_code', $attributeCode);
//        if ($attributeValue->getId()) {
//            $this->addData($attributeValue->getData())
//                ->setId($attributeValue->getId());
//        }
//
//        return $this;
//    }

    public function loadAttributeValue($bannerId, $storeViewId, $attributeCode)
    {
        $attributeValue = $this->valueCollectionFactory->create()
            ->addFieldToFilter('banner_id', $bannerId)
            ->addFieldToFilter('store_id', $storeViewId)
            ->addFieldToFilter('attribute_code', array('in' => $attributeCode));
//            ->setPageSize(1)->setCurPage(1)
//            ->getFirstItem();
        foreach($attributeValue as $model){
            $this->setData('banner_id', $bannerId)
                ->setData('store_id', $storeViewId)
                ->setData('attribute_code', $model->getData('attribute_code'));
            if ($model->getId()) {
                $this->addData($model->getData())
                    ->setId($model->getId());
            }
        }

        return $attributeValue;
    }
}
