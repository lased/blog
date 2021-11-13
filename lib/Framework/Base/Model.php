<?

namespace Framework\Base;

use Rakit\Validation\Validator;

class Model
{
    private $errors = [];
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

    function validation()
    {
        $validator = new Validator;
        $attributes = $this->getAttributes();

        return $validator->make($attributes, $this->rules);
    }

    function validate()
    {
        $validation = $this->validation();
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
            var_dump($entry);
            die;
            return \R::store($entry);
        } catch (\Throwable $th) {
            return false;
        }
    }

    function delete(int $id)
    {
        try {
            $entry = \R::load($this->table, $id);
            \R::trash($entry);

            return $id;
        } catch (\Throwable $th) {
            return false;
        }
    }

    function findById(int $id)
    {
        $result = \R::findOne($this->table, 'id = ?', [$id]);

        if ($result) return $result->export();

        return null;
    }

    function findAll(array $options = [])
    {
        $order =
            !empty($options['order']) && !empty($options['order']['column']) && !empty($options['order']['dir'])
            ? "ORDER BY {$options['order']['column']} {$options['order']['dir']}"
            : '';
        $where = !empty($options['where']) ? $options['where'] : '';
        $offset = !empty($options['offset']) ? $options['offset'] : 0;
        $limit = !empty($options['limit']) ? $options['limit'] : 10;

        $entries = \R::findAll($this->table, " {$where} {$order} LIMIT :limit OFFSET :offset ", [
            ':limit' => $limit,
            ':offset' => $offset
        ]);

        return \R::exportAll($entries);
    }

    function count()
    {
        return \R::count($this->table);
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
