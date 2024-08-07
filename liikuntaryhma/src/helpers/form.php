<?php
/*
function cleanArrayData($array=[]) {
  $result = array();
  foreach ($array as $key => $value) {
    $cleaned = trim($value);
    $cleaned = stripslashes($cleaned);
    $result[$key] = $cleaned;
  }
  return $result;
}*/

/*enhanced version of cleanArrayData function:
- now checks if the input is an array and throws an exception if it isn’t. This helps to catch errors early.
- uses array_map to apply cleaning recursively to nested arrays.
*/
function cleanArrayData($array = []) {
    if (!is_array($array)) {
        throw new InvalidArgumentException('Expected an array as input.');
    }
    
    return array_map(function($value) {
        // Check if value is an array and process recursively
        if (is_array($value)) {
            return cleanArrayData($value);
        }
        
        // Clean string values
        if (is_string($value)) {
            $value = trim($value);
            $value = stripslashes($value);
        }
        
        return $value;
    }, $array);
}

function getValue($values, $key) {
    if (array_key_exists($key, $values)) {
      return htmlspecialchars($values[$key]);
    } else {
      return null;
    }
  }
  

?>
