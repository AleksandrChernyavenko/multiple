<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 03.02.2015
 * Time: 12:00
 */

namespace common\widgets;

use kartik\widgets\Select2;
use yii\web\JsExpression;

class Select2Load extends Select2
{
    public function init()
    {
        $this->registerDefaultPluginOptions();
        parent::init();
    }

    public function registerDefaultPluginOptions()
    {
        if(empty($this->pluginOptions['formatResult'])) {
            $this->pluginOptions['formatResult'] = new JsExpression('function(item) { return item.title;}');
        }
        if(empty($this->pluginOptions['formatSelection'])) {
            $this->pluginOptions['formatSelection'] = new JsExpression('function(item) { return item.title;}');
        }
        if(empty($this->pluginOptions['ajax']['results'])) {
            $this->pluginOptions['ajax']['results'] = new JsExpression('function(data,page) { return {results:data}; }');
        }
        if(empty($this->pluginOptions['ajax']['data'])) {
            $this->pluginOptions['ajax']['data'] = new JsExpression('function(term,page) { return {q:term}; }');
        }
        if(empty($this->pluginOptions['ajax']['dataType'])) {
            $this->pluginOptions['ajax']['dataType'] = 'json';
        }
        if(empty($this->pluginOptions['allowClear'])) {
            $this->pluginOptions['allowClear'] = true;
        }
        if(empty($this->pluginOptions['placeholder'])) {
            $this->pluginOptions['placeholder'] = 'Начните вводить...';
        }
        if(empty($this->pluginOptions['initSelection'])) {
            $url = $this->pluginOptions['ajax']['url'];
            $this->pluginOptions['initSelection'] =  new JsExpression("
                    function (element, callback) {
                        var id=$(element).val();
                        if (id !== '') {
                            $.ajax('{$url}?id=' + id, {
                                dataType: 'json'
                            }).done(function(data) {
                                    callback(data);
                             });
                        }
                    }
                    ");
        }
    }
}