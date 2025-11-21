<?php

namespace Strativ\Widget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Test extends Template implements BlockInterface
{
    /**
     * Set the template file for this widget.
     * @var string
     */
    protected $_template = "widget/test.phtml";
}
