<?php 
namespace App\Helper;
use Symfony\Component\HttpFoundation\Response;

class JsonHelper
{
    public static function decodeAndValidate(string $jsonStr, array $schema = null)
    {
        $data = json_decode($jsonStr, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Błędnie przesłano dane', Response::HTTP_CONFLICT);
        }

        if ($schema && !self::validateAgainstSchema($data, $schema)) {
            throw new \Exception('Błędnie przesłano dane', Response::HTTP_CONFLICT);
        }

        return $data;
    } 
    
    public static function validateAgainstSchema(array $data, array $schema): bool
    {
        foreach ($schema as $key => $type) {
            if (!isset($data[$key])) {
                return false;
            }

            if (is_array($type)) {
                if (!is_array($data[$key])) {
                    return false;
                }

                foreach ($data[$key] as $item) {
                    if (gettype($item) !== $type[0]) {
                        return false;
                    }
                }
            } else {
                if (gettype($data[$key]) !== $type) {
                    return false;
                }
            }
        }

        return true;
    }
}