<?php

namespace Iagen\MaGPT\Block\Adminhtml;

use Magento\Backend\Block\Widget\Container;
use Magento\Backend\Block\Widget\Context;

class ViewProductButton extends Container
{
    protected $scopeConfig;
    public function __construct(
        Context $context,array $data = [],
        ) 
    
    {
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->addButton(
            'preview_product',
            [
                'label' => __('GPT'),
                'on_click' => 'getInputText()',
                'class' => 'view action-secondary',
                'sort_order' => 20
            ]
        );
        parent::_construct();
    }
}


