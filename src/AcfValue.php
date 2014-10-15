<?php

namespace AcfUtil;

class AcfValue implements \ArrayAccess
{
  protected $_array = null;

  // init
  // ====

  function __construct($array)
  {
    $this->_array = $array;
  }

  // overload
  // ========

  public function __get($name)
  {
    if (!isset($this->_array[$name])) {
      return null;
    }

    $field = $this->_array[$name];

    if (isset($field['sub_fields'])) {

      // sub field map to make assigning sub field info simple

      $sub_field_map = array();

      foreach ($field['sub_fields'] as $sub_field) {
        if (isset($sub_field['sub_fields'])) {
          $sub_field_map[$sub_field['name']] = $sub_field['sub_fields'];
        }
      }

      // change [raw sub field values] to [AcfObject instances]

      return array_map(function($array) use($sub_field_map) {
        foreach ($array as $key => $value) {
          $array_[$key] = array();

          // wrap value

          $array_[$key]['value'] = $value;

          // give sub field info

          if (isset($sub_field_map[$key])) {
            $array_[$key]['sub_fields'] = $sub_field_map[$key];
          }
        }
        return new static($array_);
      }, $field['value']);

    } else {
      return $this->_array[$name]['value'];
    }
  }

  public function __set($name, $value)
  {
  }

  public function __isset($name)
  {
    return isset($this->_array[$name]);
  }

  public function __unset($name)
  {
  }

  // array access
  // ============

  public function offsetGet($offset)
  {
    return $this->__get($offset);
  }

  public function offsetSet($offset, $value)
  {
    $this->__set($offset, $value);
  }

  public function offsetExists($offset)
  {
    return $this->__isset($offset);
  }

  public function offsetUnset($offset)
  {
    $this->__unset($offset);
  }
}
