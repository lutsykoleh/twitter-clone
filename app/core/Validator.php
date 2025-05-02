<?php

namespace Core;

use Core\Database;

class Validator
{
  protected $db;
  protected $errors = [];
  protected $messages = [
    'required' => 'The :fieldname: field is required',
    'min' => 'The :fieldname: field must be a minimum of :rulevalue: characters',
    'max' => 'The :fieldname: field must be a maximum of :rulevalue: characters',
    'email' => 'Not valid email',
    'unique' => 'The :fieldname: is already taken',
  ];

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function validate($data = [], $rules = [])
  {
    foreach ($data as $fieldname => $value) {
      if (isset($rules[$fieldname])) {
        $this->check([
          'fieldname' => $fieldname,
          'value' => $value,
          'rules' => $rules[$fieldname],
        ]);
      }
    }
    return $this;
  }

  protected function check($field)
  {
    foreach ($field['rules'] as $rule => $rule_value) {
      if (method_exists($this, $rule)) {
        if (!call_user_func_array([$this, $rule], [$field['value'], $rule_value])) {
          $this->addError(
            $field['fieldname'],
            str_replace(
              [':fieldname:', ':rulevalue:'],
              [$field['fieldname'], $rule_value],
              $this->messages[$rule] ?? 'Validation error on :fieldname:'
            )
          );
        }
      }
    }
  }

  protected function addError($fieldname, $error)
  {
    $this->errors[$fieldname][] = $error;
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function hasErrors()
  {
    return !empty($this->errors);
  }

  public function listErrors($fieldname)
  {
    $output = '';
    if (isset($this->errors[$fieldname])) {
      $output .= "<div class='validation-errors'><ul class='list-errors'>";
      foreach ($this->errors[$fieldname] as $error) {
        $output .= "<li>$error</li>";
      }
      $output .= "</ul></div>";
    }
    return $output;
  }

  // Validator methods
  protected function required($value, $rule_value)
  {
    return !empty(trim($value));
  }

  protected function min($value, $rule_value)
  {
    return mb_strlen($value, 'UTF-8') >= $rule_value;
  }

  protected function max($value, $rule_value)
  {
    return mb_strlen($value, 'UTF-8') <= $rule_value;
  }

  protected function email($value, $rule_value)
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  protected function unique($value, $rule_value)
  {
    $data = explode(':', $rule_value);
    $stmt = $this->db->query("SELECT {$data[1]} FROM {$data[0]} WHERE {$data[1]} = ?", [$value]);
    return !$stmt->fetchColumn();
  }
}
