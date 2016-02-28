<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outputter_service_provider{

    private $CI;

    public function __construct()
    {
       $this->CI =& get_instance();
    }

    /**
     * Convert the parameter value to json format.
     * @param  array $value 
     * @return Response        
     */
    public function toJson($value)
    {   
        $this->CI->load->library('output');
       return $this->output->set_content_type('application/json')
            ->set_output(json_encode($value));
    }
    


}

