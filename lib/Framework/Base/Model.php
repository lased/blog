<?

namespace Framework\Base;

use Framework\App;
use Rakit\Validation\Validator;

class Model
{
    private $errors;
    private $table;
    private $rules;

    function __construct(array $data = [])
    {
        $this->loadData($data);
        $this->table = static::table();
        $this->rules = static::rules();

        if (empty($this->table))
            throw new \Exception("В модели {get_class($this)} отсутствует поле 'table'", 500);
    }

    static function table()
    {
        return null;
    }

    static function rules()
    {
        return [];
    }

    function loadData(array $data = [])
    {
        if (!count($data)) return null;

        $names = $this->getAttributeNames();

        foreach ($names as $property) {
            if (array_key_exists($property, $data))
                $this->$property = $this->attributes[$property] = $data[$property];
        }

        return true;
    }

    function getAttributeNames()
    {
        $class = new \ReflectionClass($this);
        $names = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic())
                $names[] = $property->getName();
        }

        return $names;
    }

    function getAttributes()
    {
        $names = $this->getAttributeNames();
        $attributes = [];

        foreach ($names as $name)
            if (!empty($this->$name))
                $attributes[$name] = $this->$name;

        return $attributes;
    }

    function getErrors()
    {
        if (!$this->errors) return [];

        return $this->errors->all();
    }

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

    static function findById(int $id)
    {
        $result = \R::findOne(static::table(), 'id = ?', [$id]);

        if ($result) return $result->export();

        return null;
    }

    static function findOne(string $sql, array $params)
    {
        $result = \R::findOne(self::table(), $sql, $params);

        if ($result) return $result->export();

        return null;
    }

    static function findAll(array $options = [])
    {
        $order =
            !empty($options['order']) && !empty($options['order']['column']) && !empty($options['order']['dir'])
            ? "ORDER BY {$options['order']['column']} {$options['order']['dir']}"
            : '';
        $where = !empty($options['where']) ? $options['where'] : '';
        $offset = !empty($options['offset']) ? $options['offset'] : 0;
        $limit = !empty($options['limit']) ? $options['limit'] : 10;

        $entries = \R::findAll(static::table(), " {$where} {$order} LIMIT :limit OFFSET :offset ", [
            ':limit' => $limit,
            ':offset' => $offset
        ]);

        return \R::exportAll($entries);
    }

    static function count()
    {
        return \R::count(static::table());
    }

    private function loadAttributes(\RedBeanPHP\OODBBean $entry)
    {
        $entry = clone $entry;
        $attributes = $this->getAttributes();

        foreach ($attributes as $key => $value)
            $entry->$key = $value;

        return $entry;
    }
}
