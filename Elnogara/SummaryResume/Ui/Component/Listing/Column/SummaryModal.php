<?php
/**
* Copyright © Elnogara Company. All rights reserved.
*/

declare(strict_types=1);

namespace Elnogara\SummaryResume\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class SummaryModal extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        protected UrlInterface $urlBuilder,
        protected OrderRepositoryInterface $orderRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $message = $item["items"] ?? "";
                $message = "{$message} <br> Entrega para: {$item["shipping_name"]}";
                $message = "{$message} <br> Data: {$item["created_at"]}";
                $message = "{$message} <br> Valor Pedido: {$item["grand_total"]}";
                $item[$this->getData('name')] = [
                    'view' => [
                        'href' => "#",
                        'confirm' => [
                            'title' => __('Summary'),
                            'message' => $message,
                            '__disableTmpl' => true,
                        ],
                        'label' => __('Summary')
                    ]
                ];
            }
        }
        
        return $dataSource;
    }
}