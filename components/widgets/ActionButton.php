<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 09.08.2015
 * Time: 13:06
 */

namespace app\components\widgets;


use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Кнопка действия в виджете GridView
 * @package app\components\widgets
 */
class ActionButton extends Widget
{
    /**
     * Иконка
     * @var string|null
     */
    public $icon = null;

    /**
     * Подпись у иконки
     * @var string|null
     */
    public $label = null;

    /**
     * Путь ссылки (если нужна)
     * @var array|string|null
     */
    public $url = null;

    /**
     * Сообщение о подтверждении (если требуется)
     * @var null|string
     */
    public $confirmMessage = null;

    /**
     * Подпись выводится как (tooltip)
     * @var string|null
     */
    public $title = null;

    /**
     * Стиль кнопки
     * @var string
     */
    public $buttonStyle = 'btn-default';

    /**
     * Включена ли кнопка
     * @var bool
     */
    public $enabled = true;

    /**
     * Класс(ы), котор(ые) нужно применить к кнопке, если она активна.
     * @var null|string
     */
    public $enabledClass = null;

    /**
     * Класс(ы), котор(ые) нужно применить к кнопке, если она не активна.
     * @var null|string
     */
    public $disabledClass = null;

    /**
     * Другие опции кнопки
     * @var array
     */
    public $options = [];

    /**
     * @inheritDoc
     */
    public function run()
    {
        return $this->renderButton();
    }

    private function renderButton()
    {

        return Html::a(
            $this->renderButtonText(),
            $this->url,
            array_merge($this->options,
                [
                    'class' => implode(
                        ' ',
                        array_merge(
                            ['btn btn-xs btn-grid-action', $this->buttonStyle, $this->getClass()],
                            array_key_exists('class', $this->options) && is_array($this->options['class'])
                                ? $this->options['class']
                                : []
                        )
                    ),
                    'disabled' => !$this->enabled,
                    'title' => $this->title,
                    'data-toggle' => 'tooltip',
                    'data-confirm' => $this->confirmMessage,
                ])
        );
    }

    private function renderButtonText()
    {
        $icon = (!empty($this->icon))
            ? Icon::show($this->icon)
            : '';
        return $icon . $this->label;
    }

    private function getClass()
    {
        return ($this->enabled)
            ? $this->enabledClass
            : $this->disabledClass;
    }

}