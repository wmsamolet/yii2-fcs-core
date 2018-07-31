<?php

namespace wmsamolet\fcs\core;

use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;

/**
 * fcs-core module definition class
 */
class Module extends BaseModule implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'wmsamolet\fcs\core\controllers';

    /** @var array */
    public $classPaths = ['@app/models'];

    public function bootstrap($app)
    {
        // TODO: Implement bootstrap() method.
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
