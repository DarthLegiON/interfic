<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 11.10.2015
 * Time: 18:19
 */

namespace app\components\models;

use ReflectionClass;
use yii\base\InvalidParamException;
use yii\base\InvalidValueException;
use yii\base\Model;
use yii\base\UnknownClassException;

abstract class ModelCollection extends Model implements ArrayModelInterface
{
    private $_attributes = [];

    /**
     * @inheritDoc
     */
    public function __construct(array $config = [])
    {
        $this->checkModelClassName();

        $this->initAttributes();

        parent::__construct($config);
    }

    /**
     * Проверяет, подходит ли класс, указанный в modelClassName()
     * @throws UnknownClassException
     */
    private function checkModelClassName()
    {
        $class = static::modelClassName();
        if (!class_exists($class)) {
            throw new UnknownClassException('Класс ' . $class . ' не найден.');
        }
        $example = new $class;
        if (!($example instanceof Model)) {
            throw new UnknownClassException('Класс ' . $class . ' не является моделью.');
        }
    }

    private function initAttributes()
    {
        $attributes = $this->attributes();
        foreach ($attributes as $attribute) {
            $this->_attributes[$attribute] = [];
        }
    }

    /**
     * @inheritDoc
     */
    public function attributes()
    {
        $class = new ReflectionClass(static::modelClassName());
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }

        return $names;
    }

    /**
     * Заполняет объект данными из массива объектов
     * @param Model[] $array
     */
    public static function fromModelsArray(array $array)
    {
        $result = new static;
        $count = count($array);
        $attributes = array_keys($result->_attributes);

        for ($index = 0; $index < $count; $index++) {
            foreach ($attributes as $attribute) {
                $result->$attribute[$index] = $array[$index]->$attribute;
            }
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        } else {
            return parent::__get($name);
        }
    }

    /**
     * @inheritDoc
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->_attributes)) {
            $class = static::modelClassName();
            if ($value instanceof $class) {
                $this->_attributes[$name] = $name;
            } else {
                throw new InvalidParamException('Разрешается передавать только экземпляры класса ' . $class . ' или его наследников.');
            }
        } else {
            parent::__set($name, $value);
        }
    }

    public function models()
    {
        $count = $this->count();
        $className = $this->modelClassName();
        $result = [];
        for ($index = 0; $index < $count; $index++) {
            $attributes = [];
            foreach ($this->attributes() as $attrName) {
                $attributes[$attrName] = $this->$attrName;
            }
            $result[] = new $className($attributes);
        }

        return $result;
    }

    /**
     * Возвращает число записей в форме
     * @return int
     */
    public function count()
    {
        $attribute = $this->attributes()[0];
        return count($this->$attribute);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if (method_exists(static::modelClassName(), 'save')) {
            $models = $this->models();
            foreach ($models as $model) {
                $model->save($runValidation, $attributeNames);
            }
        } else {
            throw new InvalidValueException('Объекты, с которыми работает класс, не имеют встроенного метода save()');
        }
    }
}