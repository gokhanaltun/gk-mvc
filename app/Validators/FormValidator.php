<?php

namespace App\Validators;

use App\System\Session;

class FormValidator
{

    private array $post_data;
    private array $errors = [];

    public function validator(array $post_data)
    {
        $this->post_data = $post_data;
        $this->errors = [];
        return $this;
    }

    public function validate()
    {
        if (empty($this->errors)) {
            $this->errors['status'] = true;
            return $this->errors;
        } else {
            $this->errors['status'] = false;
            $this->errors['errorType'] = 'formValidateError';
            return $this->errors;
        }
    }

    public function require(array $post_data_keys)
    {
        for ($i = 0; $i < count($post_data_keys); $i++) {
            if (!isset($this->post_data[$post_data_keys[$i]]) or empty($this->post_data[$post_data_keys[$i]])) {
                $this->errors['require'][$post_data_keys[$i]] = ' The field cannot be null ';
            }
        }
        return $this;
    }

    public function textMin(array $post_data_keys, array $minValues)
    {

        for ($i = 0; $i < count($post_data_keys); $i++) {
            if (isset($this->post_data[$post_data_keys[$i]])) {
                $data = $this->post_data[$post_data_keys[$i]];
                $charLen = strlen($data);
                if ($charLen < $minValues[$i]) {
                    $this->errors['textMin'][$post_data_keys[$i]] = ' The number of characters cannot be less than ' . $minValues[$i];
                }
            }
        }
        return $this;
    }

    public function textMax(array $post_data_keys, array $minValues)
    {
        for ($i = 0; $i < count($post_data_keys); $i++) {
            if (isset($this->post_data[$post_data_keys[$i]])) {
                $data = $this->post_data[$post_data_keys[$i]];
                $charLen = strlen($data);
                if ($charLen > $minValues[$i]) {
                    $this->errors['textMax'][$post_data_keys[$i]] = ' The number of characters cannot be greater than ' . $minValues[$i];
                }
            }
        }
        return $this;
    }

    public function min(array $post_data_keys, array $minValues)
    {
        for ($i = 0; $i < count($post_data_keys); $i++) {
            if (isset($this->post_data[$post_data_keys[$i]])) {
                $data = $this->post_data[$post_data_keys[$i]];
                if ($data < $minValues[$i]) {
                    $this->errors['min'][$post_data_keys[$i]] = ' The number cannot be less than ' . $minValues[$i];
                }
            }
        }
        return $this;
    }

    public function max(array $post_data_keys, array $minValues)
    {
        for ($i = 0; $i < count($post_data_keys); $i++) {
            if (isset($this->post_data[$post_data_keys[$i]])) {
                $data = $this->post_data[$post_data_keys[$i]];
                if ($data > $minValues[$i]) {
                    $this->errors['max'][$post_data_keys[$i]] = ' The number cannot be greater than ' . $minValues[$i];
                }
            }
        }
        return $this;
    }

    public function email(array $post_data_keys)
    {

        for ($i = 0; $i < count($post_data_keys); $i++) {
            if (isset($this->post_data[$post_data_keys[$i]])) {
                $data = $this->post_data[$post_data_keys[$i]];
                if (!preg_match("/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $data)) {
                    $this->errors['email'][$post_data_keys[$i]] = ' Mail address is not valid';
                }
            }
        }
        return $this;
    }

    public function regex(array $post_data_keys, array $patterns, array $errorNames, array $errorMessages)
    {

        for ($i = 0; $i < count($post_data_keys); $i++) {
            if (isset($this->post_data[$post_data_keys[$i]])) {
                $data = $this->post_data[$post_data_keys[$i]];
                if (!preg_match($patterns[$i], $data)) {
                    $this->errors[$errorNames[$i]][$post_data_keys[$i]] = $errorMessages[$i];
                }
            }
        }
        return $this;
    }

    public function csrf()
    {

        $session_csrf_data = Session::get('csrfToken');

        if (isset($this->post_data['csrf']) or !empty($this->post_data['csrf'])) {
            if ($this->post_data['csrf'] != $session_csrf_data) {
                $this->errors['csrfToken']['csrf'] = ' Invalid Csrf Token...!';
            }
        } else {
            $this->errors['csrfToken']['csrf'] = ' Csrf Token Cannot be null...!';
        }
        return $this;
    }
}
