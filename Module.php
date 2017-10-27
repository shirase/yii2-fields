<?php

namespace shirase\modules\fields;

/**
 * field module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'shirase\modules\fields\controllers';

    public $defaultRoute = 'field/index';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
