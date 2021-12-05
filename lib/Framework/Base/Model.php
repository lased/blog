<?

namespace Framework\Base;

use Framework\App;
use Rakit\Validation\Validator;

/**
 * Базовый класс для модели
 */
class Model
{
    private $errors;
    private $table;
    private $rules;

    /**
     * Конструктор класса Model
     * 
     * @param array $data Ассоциативный массив с данными модели
     */
    function __construct(array $data = [])
    {
        if (empty(static::table())) {
            throw new \Exception("В модели {get_class($this)} отсутствует поле 'table'", 500);
        }

        $this->loadData($data);
        $this->table = static::table();
        $this->rules = static::rules();
    }

    /**
     * Наименование таблицы модели
     * 
     * @return string|null Наименование таблицы модели
     */
    static function table()
    {
        return null;
    }

    /**
     * Набор правил валидации модели
     * 
     * @return array Набор правил валидации модели
     */
    static function rules()
    {
        return [];
    }

    /**
     * Загрузка данных в модель
     * 
     * @param array $data Ассоциативный массив с данными модели
     * 
     * @return bool|null Результат загрузки данных в модель
     */
    function loadData(array $data = [])
    {
        if (!count($data)) {
            return null;
        }

        $names = $this->getAttributeNames();

        foreach ($names as $property) {
            if (array_key_exists($property, $data)) {
                $this->$property = $this->attributes[$property] = $data[$property];
            }
        }

        return true;
    }

    /**
     * Получить имена публичных атрибутов
     * 
     * @return array Список имен атрибутов
     */
    function getAttributeNames()
    {
        $class = new \ReflectionClass($this);
        $names = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }

        return $names;
    }

    /**
     * Получить атрибуты со значениями
     * 
     * @return array Ассоциативный массив атрибутов со значениями
     */
    function getAttributes()
    {
        $names = $this->getAttributeNames();
        $attributes = [];

        foreach ($names as $name) {
            if (!empty($this->$name)) {
                $attributes[$name] = $this->$name;
            }
        }

        return $attributes;
    }

    /**
     * Получить ошибки при выполнении валидации
     * 
     * @return array Массив с ошибками
     */
    function getErrors()
    {
        if (!$this->errors) {
            return [];
        }

        return $this->errors->all();
    }

    /**
     * Валидация данных модели
     * 
     * @return bool Результат валидации
     */
    function validate()
    {
        $validator = new Validator;
        $validation = $validator->make($this->getAttributes(), $this->rules);
        $validation->setMessages(App::$store->get('translate')['validator'] ?? []);
        $validation->validate();

        if ($validation->fails()) {
            $this->errors = $validation->errors();

            return false;
        }

        return true;
    }

    /**
     * Добавить запись в таблицу БД
     * 
     * @return bool|integer|string Результат операции
     */
    function save()
    {
        try {
            $entry = \R::dispense($this->table);
            $entry = $this->loadAttributes($entry);

            return \R::store($entry);
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Обновление записи в таблице БД по ID
     * 
     * @param int $id ID записи
     * 
     * @return bool|integer|string Результат операции
     */
    function update(int $id)
    {
        try {
            $entry = \R::load($this->table, $id);
            $entry = $this->loadAttributes($entry);

            return \R::store($entry);
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Удаление записи в таблице БД по ID
     * 
     * @param int $id ID записи
     * 
     * @return bool|integer Результат операции
     */
    static function delete(int $id)
    {
        try {
            $entry = \R::load(static::table(), $id);
            \R::trash($entry);

            return $id;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Поиск записи по ID
     * 
     * @param int $id ID записи
     * 
     * @return array|null Результат операции
     */
    static function findById(int $id)
    {
        $result = \R::findOne(static::table(), 'id = ?', [$id]);

        if ($result) {
            return $result->export();
        }

        return null;
    }

    /**
     * Поиск одной записи по заданным параметрам
     * 
     * @param string $sql Параметры поиска
     * @param array $params Массив значений, которые будут привязаны к параметрам в запросе
     * 
     * @return array|null Результат операции
     */
    static function findOne(string $sql, array $params)
    {
        $result = \R::findOne(static::table(), $sql, $params);

        if ($result) {
            return $result->export();
        }

        return null;
    }

    /**
     * Поиск всех записей по заданным параметрам
     * 
     * @param array $options Параметры поиска. 
     * Сортировка - 'order' => ['dir' => 'ASC', 'column' => 'col'],
     * условия поиска - 'where' => ['sql' => 'title = :title', 'params' => [':title' => $title]],
     * отступ - 'offset' => 2,
     * ограничение выбоки - 'limit' => 10.
     * 
     * @return array Результат операции
     */
    static function findAll(array $options = [])
    {
        $order =
            !empty($options['order']) && !empty($options['order']['column']) && !empty($options['order']['dir'])
            ? "ORDER BY {$options['order']['column']} {$options['order']['dir']}"
            : '';
        $where = [
            'sql' => !empty($options['where']['sql']) ? $options['where']['sql'] : '',
            'params' => !empty($options['where']['params']) ? $options['where']['params'] : []
        ];
        $offset = !empty($options['offset']) ? $options['offset'] : 0;
        $limit = !empty($options['limit']) ? $options['limit'] : 10;
        $entries = \R::findAll(static::table(), " {$where['sql']} {$order} LIMIT :limit OFFSET :offset ", $where['params'] + [
            ':limit' => $limit,
            ':offset' => $offset
        ]);

        return \R::exportAll($entries);
    }

    /**
     * Счетчик количества записей по заданным параметрам
     * 
     * @param array $options Параметры поиска. 
     * Условия поиска - ['sql' => 'title = :title', 'params' => [':title' => $title]]
     * 
     * @return array Результат операции
     */
    static function count(array $options = [])
    {
        $options = [
            'sql' => !empty($options['sql']) ? $options['sql'] : '',
            'params' => !empty($options['params']) ? $options['params'] : []
        ];

        return \R::count(static::table(), $options['sql'], $options['params']);
    }

    /**
     * Загрузка новых значений атрибутов модели
     *  
     * @param \RedBeanPHP\OODBBean $entry Модель, в которую загружаются новые значения
     * 
     * @return \RedBeanPHP\OODBBean Клон модели с новыми значениями
     * 
     */
    private function loadAttributes(\RedBeanPHP\OODBBean $entry)
    {
        $entry = clone $entry;
        $attributes = $this->getAttributes();

        foreach ($attributes as $key => $value) {
            $entry->$key = $value;
        }

        return $entry;
    }
}
