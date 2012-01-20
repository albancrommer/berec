<?php
    /**
    * 
    */
    class Default_Model_File
    {
        protected $_data;
        protected $_response;
        
        function __construct( $data )
        {
            $this->_data = $data;
        }
        
        public function get()
        {
            if( null == $this->_data ){
                throw( new Exception("Default_Model_File:get missing parameter : data."));}
            
            $access         = $this->_data['access'];
            $country        = $this->_data['country'];
            $isp            = $this->_data['isp'];
            
            $this->_response= '"Access";"'.$access.'"'."\n";
            
            $this->_response= '"Country";"Operator";"Type of measure*";"";"Description of the measure";"Objective";"Method of implementation (if applicable)";"Number of subscribers having a subscription where this measure is implemented";"How is the user informed?";"Can the user activate/deactivate the measure? How?";"Protection of business secret"'."\n";
            
            for ($i=0; $i < 3; $i++) { 
                $firstCell= 'row_'.$i.'_a';
                if(!$this->_data[$firstCell]){
                    continue;
                }

                $line[] = $country;
                $line[] = $isp;
                $line[] = $this->_data['row_'.$i.'_a'];
                $line[] = "";
                $line[] = $this->_data['row_'.$i.'_b'];
                $line[] = "";
                $line[] = "";
                $line[] = "";
                $line[] = $this->_data['row_'.$i.'_c'];
                $line[] = $this->_data['row_'.$i.'_d'];
                $line[] = "";
                
                
                $str = '"';
                $str .= implode('";"',$line);
                $str .= '"';
                $str .= "\n";
                
                $this->_response .= $str;
                unset($line);
            }
            
            return $this->_response;
        }
    }
    