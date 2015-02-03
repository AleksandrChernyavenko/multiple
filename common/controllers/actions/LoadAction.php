<?php

namespace common\controllers\actions;
use yii\base\Action;
use Yii;
use yii\db\Exception;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\VarDumper;

/**
 * Class  LoadAction
 * @property string $table     Имя таблицы
 * @property string $format    Формат строки вывода
 * @property array  $fields    Поля, по которым осуществляется поиск
 * @property string $filter    Дополнительные условия
 * @property string $pattern   Шаблон регулярного выражения, по которму осуществляется поиск переменных
 * @property string $paramName Названия $_GET паарметра, содержащего значение запроса
 * <code>
 * 'load' => array(
 *      'class' => 'common.controllers.actions.LoadAction',
 *      'fields' => array('id', 'company', 'affiliate_group_id.affiliate_groups.name', '{first_name, last_name}'),
 *      'table' => 'affiliates',
 *      'format' => '{id} {company} {affiliate_group_id.affiliate_groups.name}',
 *      'joins' => array(array('table'=>'', 'on' => '' ))
 * ),
 * </code>
 */
class LoadAction extends Action
{
    public $table;
    public $format;
    public $fields = [];
    // todo Доделать конструктор, сейчас в виде SQL
    public $filter;
    public $pattern = '/{(\w[\w\.]*)}/i';
    public $patternFilter = '/:(\w[\w\.]/*)/i';
    public $joins = [];
    public $paramName = 'q';
    public $order;
    public $return = 'id';
    public $group = false;

    public $limit = 100;

    public function run()
    {
        $queryStr = $this->getRequestParam($this->paramName, '');
        $id = (int)$this->getRequestParam('id', 0);

        $query = new Query();

        // Устанавливаем связи к другой таблице на основе формата
        preg_match_all($this->pattern, $this->format, $matches);
        $select = ['t.*'];
        $arrJoin = [];
        foreach ($matches[1] as $i => $match) {
            $elements = explode('.', $match);

            if (count($elements) == 3) { // Если есть связи к другой таблице
                // $elements[0] - имя столбца
                // $elements[1] - имя ref таблицы
                // $elements[2] - название столбца ref таблицы
                $tName = $this->getTableField($elements[1]); // Алиас ref таблицы
                $arrJoin[$elements[1]] = ['name' => $elements[1] . " {$tName}", 'value' => "{$tName}.id =  t.{$elements[0]}"];
                $select[] = "{$tName}.{$elements[2]} as " . $this->getKeyField($elements[2]);
            }
        }

        //Устанавливаем условия и связи на на основе полей выборки
        $arrWhere = [];
        foreach ($this->fields as $i => $field) {
            $elements = explode('.', $field);
            if (count($elements) == 3) { // Если есть связи к другой таблице
                // $elements[0] - имя столбца
                // $elements[1] - имя ref таблицы
                // $elements[2] - название столбца ref таблицы
                $tName = $this->getTableField($elements[1]);
                if (!isset($arrJoin[$elements[1]])) {
                    $arrJoin[$elements[1]] = ['name' => $elements[1] . " {$tName}", 'value' => "{$tName}.id =  t.{$elements[0]}"];
                }

                $arrWhere[] = $tName . '.' . $elements[2];
            } else {
                $arrWhere[] = $field;
            }
        }

        //определяем есть ли поле id
        $queryId = false;
        foreach ($this->fields as $i => $field) {
            if (!$queryId && $field == 'id') {
                $queryId = true;
            }
        }
        $queryId = $queryId ? (int)$this->getRequestParam('id') : false;



        // joins
        foreach ($arrJoin as $join) {
            //TODO: поправить это
            VarDumper::dump($arrJoin,3,3);
            exit;
            $query->join($join['name'], $join['value']);
        }

        foreach ($this->joins as $item) {
            $query->leftJoin($item['table'], $item['on']);
        }


        //where
        if ($id) { // Если нужно получить 1 запись по id
            $where = "t.{$this->return} = " . $id;
        } elseif ($queryId) { //первый if для вывода списка уже сформированных запросов ( по ajax для заполнения фильра выбранными ранее данными ) elseif  если в запросе пришло число(ищем по id)
            $where = "t.id = " . $queryId;
        } else {
            if (count($this->fields) > 1) {
                $where = (isset($arrWhere[0]) && strpos($arrWhere[0], 't.') !== 0 ? ' t.' : "") . implode(' LIKE :query OR ', $arrWhere) . ' LIKE :query ';
            } elseif (count($this->fields)) {
                $where = (strpos($this->fields[0], 't.') !== 0 ? ' t.' : '') . $this->fields[0] . ' LIKE :query ';
            } else {
                throw new Exception('Необходимо указать поля выборки');
            }
        }



        $query->select($select);
        $query->from($this->table . ' t ');
        $query->andWhere($where,[':query'=>'%'.$queryStr.'%']);


        if ($this->limit) {
            $query->limit($this->limit);
        }

        $params = [];

        if ($this->filter) {
            // Заменяем все переменные в фильтре
            preg_match_all($this->patternFilter, $this->filter, $matches);

            // параметры в условии
            if (isset($matches[1]) && !empty($matches[1])) {
                foreach ($matches[1] as $i => $match) {
                    $val = \Yii::app()->request->getParam($match, '');
                    $params[':' . $match] = $val;
                }

                $query->andWhere($this->filter, $params);
            } else {
                $query->andWhere($this->filter);
            }

        }

        $query->orderBy($this->order);

        if ($this->group) {
            $query->group = $this->group;
        }


        $data = $query->createCommand()->queryAll();


        $format = $this->format;
        /** @var $that LoadAction */
        $that = $this;
        $data = array_map(
            function ($item) use ($format, $that) {
                // Замена переменных в формате
                $title = preg_replace_callback(
                    $that->pattern,
                    function ($m) use ($item, $that) {
                        $variable = $m[1]; // Переменная из формата "{variable}"
                        $elements = explode('.', $variable);
                        if (count($elements) == 3) { // Если поле из другой таблицы
                            return isset($item[$that->getKeyField($elements[2])]) ? $item[$that->getKeyField($elements[2])] : '';
                        } else {
                            return isset($item[$variable]) ? $item[$variable] : '';
                        }
                    },
                    $format
                );
                $title = preg_replace_callback(
                    '{(active|paused|blocked|deleted)}',
                    function ($m) {
                        $val = $m[1];

                        return \common\enums\StatusEnum::getClientValue($val);
                    },
                    $title
                );
                $title = Html::encode($title); //XSS
                // возвращаем в качестве ID  $that->return ( по умолчанию = id )
                if (isset($item[$that->return])) {
                    return ['id' => $item[$that->return], 'title' => $title];
                } else {
                    return ['id' => $item['id'], 'title' => $title];
                }
            },
            $data
        );

        if ($id) { // Убираем вложенный массив для одной строки
            $data = array_shift($data);
        }

        echo $this->sendJsonResult($data);
        Yii::$app->end();
    }

    private function getRequestParam($name, $defaultValue = null)
    {
        return !empty($_REQUEST[$name]) ? $_REQUEST[$name] : $defaultValue;
    }

    /**
     * Получить JSON|JSONP строку из данных
     * @param $results данные
     * @return string JSON|JSONP строка с данными
     */
    private function sendJsonResult($results)
    {
        header('Content-type: application/json; charset=UTF-8');
        $json = json_encode($results);
        if($this->getRequestParam('callback')) {
            return Yii::app()->request->getParam('callback') . ' (' . $json . ');';
        } else {
            return $json;
        }
    }

    /**
     * Получить алиас имени поля по его имени
     * @param $name Имя поля
     * @return string Имя алиаса поля
     */
    public function getKeyField($name)
    {
        return 'f' . substr(md5($name), 0, 8);
    }

    /**
     * Получить алиас имени таблицы по его имени
     * @param $name Имя поля
     * @return string Имя алиаса таблицы
     */
    public function getTableField($name)
    {
        return 't' . substr(md5($name), 0, 8);
    }



}
