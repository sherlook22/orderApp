<?php

namespace App\Components;

final class ArrayReader
{
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    
    public function findInt(string $key, int $default = null):?int
    {
        $value = $this->find($key, $default);

        if ($this->isNullOrBlank($value)) {
            return null;
        }
        
        return is_int($value) ? $value : null;

    }


    public function findString(string $key, string $default = null):?string
    {
        $value = $this->find($key, $default);

        if ($value === null) {
            return null;
        }

        return is_string($value) && $value != "" ? $value : null;
    }
    

    public function findArray(string $key, array $default = null):?array
    {
        $value = $this->find($key, $default);

        if ($this->isNullOrBlank($value)) {
            return null;
        }

        return is_array($value) && $value != [] ? $value : null;
    }


    public function findFloat(string $key, float $default = null):?float
    {
        $value = $this->find($key, $default);

        if ($this->isNullOrBlank($value)) {
            return null;
        }

        is_float($value) ? $value : null;
    }

    
    public function findBool(string $key, bool $default = null)
    {
        $value = $this->find($key, $default);

        if ($this->isNullOrBlank($value)) {
            return null;
        }

        is_bool($value) ? $value : null;
    }

    /**
     * Find mixed value.
     *
     * @param string $path The path
     * @param mixed|null $default The default value
     *
     * @return mixed|null The value
     */
    public function find(string $path, $default = null)
    {
        if (array_key_exists($path, $this->data)) {
            return $this->data[$path] ?? $default;
        }

        if (strpos($path, '.') === false) {
            return $default;
        }

        $pathKeys = explode('.', $path);

        $arrayCopyOrValue = $this->data;

        foreach ($pathKeys as $pathKey) {
            if (!isset($arrayCopyOrValue[$pathKey])) {
                return $default;
            }
            $arrayCopyOrValue = $arrayCopyOrValue[$pathKey];
        }

        return $arrayCopyOrValue;
    }

    /**
     * Return all data as array.
     *
     * @return array The data
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Test whether or not a given path exists in $data.
     * This method uses the same path syntax as Hash::extract().
     *
     * Checking for paths that could target more than one element will
     * make sure that at least one matching element exists.
     *
     * @param string $path The path to check for
     *
     * @return bool The existence of path
     */
    public function exists(string $path): bool
    {
        $pathKeys = explode('.', $path);

        $arrayCopyOrValue = $this->data;

        foreach ($pathKeys as $pathKey) {
            if (!array_key_exists($pathKey, $arrayCopyOrValue)) {
                return false;
            }
            $arrayCopyOrValue = $arrayCopyOrValue[$pathKey];
        }

        return true;
    }

    /**
     * Is empty.
     *
     * @param string $path The path
     *
     * @return bool Status
     */
    public function isEmpty(string $path): bool
    {
        return empty($this->find($path));
    }

    /**
     * Is null or blank.
     *
     * @param mixed $value The value
     *
     * @return bool The status
     */
    private function isNullOrBlank($value): bool
    {
        return $value === null || $value === '';
    }
}
