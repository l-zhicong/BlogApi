<?php
// 应用公共文件

use app\lib\exception\MsgException;

if (!function_exists('E')) {
    /**
     * 抛出异常处理
     *
     * @param string $msg 异常消息
     * @param integer $code 异常代码 默认为0
     *
     * @throws Exception
     */
    function E($msg, $code = null)
    {
        throw new MsgException($msg,$code);
    }
}

if (!function_exists('formatTree')) {
    function formatTree(&$options, $name, $pidName = 'pid', $pid = 0, $level = 0, $data = []): array
    {
        $_options = $options;
        foreach ($_options as $k => $option) {
            if ($option[$pidName] == $pid) {
                $value = ['id' => $k, 'title' => $option[$name]];
                unset($options[$k]);
                $value['children'] = formatTree($options, $name, $pidName, $k, $level + 1);
                $data[] = $value;
            }
        }
        return $data;
    }
}

if (!function_exists('formatCascaderData')) {
    function formatCascaderData(&$options, $name, $baseLevel = 0, $pidName = 'pid', $pid = 0, $level = 0, $data = []): array
    {
        $_options = $options;
        foreach ($_options as $k => $option) {
            if ($option[$pidName] == $pid) {
                $value = ['value' => $k, 'label' => $option[$name]];
                unset($options[$k]);
                $value['children'] = formatCascaderData($options, $name, $baseLevel, $pidName, $k, $level + 1);
                if (!count($value['children'])) unset($value['children']);
                $data[] = $value;
            }
        }
        return $data;
    }
}

/**
 * 无线级分类处理
 *
 * @param array $data 数据源
 * @param string $idName 主键
 * @param string $fieldName 父级字段
 * @param string $childrenKey 子级字段名
 * @return array
 * @author lst
 * @date 2021-03-09
 */
if (!function_exists('formatCategory')) {
    function formatCategory($data, $idName = "id", $fieldName = 'pid', $childrenKey = 'children')
    {
        $items = [];
        foreach ($data as $item) {
            $items[$item[$idName]] = $item;
        }
        $result = array();
        foreach ($items as $item) {
            if (isset($items[$item[$fieldName]])) {
                $items[$item[$fieldName]][$childrenKey][] = &$items[$item[$idName]];
            } else if($item[$fieldName] == 0){
                $result[] = &$items[$item[$idName]];
            }
        }
        return $result;
    }
}

/**
 * 对象 转 数组
 *
 * @param object $obj 对象
 * @return array
 */
if (!function_exists('object_to_array')) {
    function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }

        return $obj;
    }
}