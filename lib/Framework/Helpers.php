<?

namespace Framework;

/**
 * Класс поддержки
 */
class Helpers
{
    /**
     * Преобразование строки в camel case форму (IndexController)
     * 
     * @param string $str Строка, которую нужно преоюразовать
     * 
     * @return string Результат преобразования
     */
    static function camelCase(string $str)
    {
        return preg_replace(
            '/(-)/',
            '',
            ucwords(strtolower($str), '-')
        );
    }
}
