# acf-util

Utilities for Advanced Custom Fields.

## Sample

`AcfUtil\AcfValue` provides simple access to field objects of Advanced Custom Fields.

```php
// initialize AcfValue with field objects for specific post
// note: `get_field_objects()` is a buildin function of Advanced Custom Fields
$acf_value = new AcfUtil\AcfValue(get_field_objects($id));

// access field
$value = $acf_value->field_name;

// access repeater field
$value = $acf_value->repeater_field_name;

foreach (var $acf_value->repeater_field_name as $repeater_field) {

  // child field is also AcfValue object
  $value = $repeater_field->field_name;

  // deeper repeater fields are accessible
  foreach (var $repeater_field->deeper_repeater_field_name as $deeper_repeater_field) {

    // this is also AcfValue object
    $value = $deeper_repeater_field->field_name;
  }
}
```

## Requirements

WordPress and Advanced Custom Fields plugin.

## License

MIT
