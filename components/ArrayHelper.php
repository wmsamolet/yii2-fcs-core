<?php

namespace wmsamolet\fcs\core\components;

use yii\base\Exception;
use yii\base\Model;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * @param array[][] $arr1
     * @param array[][] $arr2
     * @return array[][]
     */
    public static function diffKeyRecursive(array $arr1, array $arr2): array
    {
        $diff = array_diff_key($arr1, $arr2);
        $intersect = array_intersect_key($arr1, $arr2);

        foreach ($intersect as $k => $v) {
            if (is_array($arr1[ $k ]) && is_array($arr2[ $k ])) {
                $d = static::diffKeyRecursive($arr1[ $k ], $arr2[ $k ]);

                if ($d) {
                    $diff[ $k ] = $d;
                }
            }
        }

        return $diff;
    }

    /**
     * @param array[][] $arr1
     * @param array[][] $arr2
     * @return array[][]
     */
    public static function diffRecursive(array $arr1, array $arr2): array
    {
        $result = [];

        foreach ($arr1 as $key => $value) {
            if (array_key_exists($key, $arr2)) {
                if (is_array($value)) {
                    $diff = static::diffRecursive($value, (array) $arr2[ $key ]);
                    if (count($diff)) {
                        $result[ $key ] = $diff;
                    }
                } else {
                    if ($value !== $arr2[ $key ]) {
                        $result[ $key ] = $value;
                    }
                }
            } else {
                $result[ $key ] = $value;
            }
        }

        return $result;
    }

    /**
     * Convert adjacency list into tree without recursion and second array.
     * @param string[] $array array to convert
     * @return array[][]|null converted array
     */
    public static function buildTree(
        array $array,
        string $pk = 'id',
        string $fk = 'parent_id',
        int $parentId = 0,
        string $childrenKey = 'children',
        bool $throwException = false
    ): ?array {
        $firstElement = current($array);

        if (! is_array($firstElement)) {
            $firstElementType = gettype($firstElement);
            if ($throwException) {
                throw new Exception(
                    'Expects parameter 1 to be a multi-dimensional array, '
                    . $firstElementType
                    . ' given'
                );
            }
            return null;
        }

        if (! array_key_exists($pk, $firstElement)) {
            if ($throwException) {
                throw new Exception('Expects child array to have a ' . $pk . ' key');
            }
            return null;
        }

        if (! array_key_exists($fk, $firstElement)) {
            if ($throwException) {
                throw new Exception('Expects child array to have a ' . $fk . '  key');
            }
            return null;
        }

        $keys = array_map(function ($e) use ($pk) {
            return $e[ $pk ];
        }, $array);

        $values = array_values($array);
        $array = array_combine($keys, $values);

        foreach ($array as $k => &$v) {
            if (isset($array[ $v[ $fk ] ])) {
                $array[ $v[ $fk ] ][ $childrenKey ][ $k ] = &$v;
            }
            unset($v);
        }

        return array_filter($array, function ($v) use ($parentId, $fk) {
            return $v[ $fk ] === $parentId;
        });
    }

    /**
     * @param int[] $idParentIdArray Array [[ID => PARENT_ID], ...]
     * @return int
     */
    public static function getTreeNodeLevel(int $id, array &$idParentIdArray, int $firstLevel = 1): int
    {
        $parentId = $idParentIdArray[ $id ];
        if ($parentId) {
            return static::getTreeNodeLevel($parentId, $idParentIdArray) + 1;
        }
        return $firstLevel;
    }

    /**
     * @param int[] $idParentIdArray Array [[ID => PARENT_ID], ...]
     * @return int[] Array [[ID => LEVEL], ...]
     */
    public static function getTreeNodeLevels(array $idParentIdArray, int $firstLevel = 1): array
    {
        $levels = [];
        foreach ($idParentIdArray as $id => $parentId) {
            $levels[ $id ] = static::getTreeNodeLevel($id, $idParentIdArray, $firstLevel);
        }
        return $levels;
    }

    /**
     * @param array[]|Model[] $array
     * @return array[]|Model[]
     */
    public static function getTreeNodes(
        array &$array,
        int $parentId = 0,
        string $pk = 'id',
        string $fk = 'parent_id'
    ): array {
        $result = [];

        foreach ($array as $k => $item) {
            $fkValue = (int) static::getValue($item, $fk);
            $pkValue = (int) static::getValue($item, $pk);

            if ($fkValue === $parentId) {
                $result[ $k ] = $item;
                $result = static::merge(
                    $result,
                    static::getTreeNodes($array, $pkValue, $pk, $fk)
                );
            }
        }

        return $result;
    }
}
