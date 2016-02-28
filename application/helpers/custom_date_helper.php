<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_date_helper{

    public function format_to_Md($value)
    {
        $d = new DateTime($value);
        return $d->format('M d, Y');
    }
}
      