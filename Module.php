<?php

namespace wmsamolet\fcs\core;

use yii\base\Module as BaseModule;
use yii\base\BootstrapInterface;

/**
 * fcs-core module definition class
 */
class Module extends BaseModule implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'wmsamolet\fcs\core\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
