<?

namespace Framework;

class Helpers
{
    static function camelCase(string $str)
    {
        return preg_replace(
            '/(-)/',
            '',
            ucwords(strtolower($str), '-')
        );
    }
}
