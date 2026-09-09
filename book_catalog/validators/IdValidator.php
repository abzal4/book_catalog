<?php

class IdValidator
{
    public static function validateId($id)
    {
        if (!$id) {
            return false;
        }
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return false;
        }
        return $id;
    }
}