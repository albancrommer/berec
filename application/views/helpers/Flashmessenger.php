<?php

class Default_View_Helper_Flashmessenger extends Zend_View_Helper_Abstract {


    private $_messages;

	public function flashmessenger( array $flashMessages = null )
	{
        if( null == $flashMessages ) return;
        $output = "";
        $this->_getMessages( $flashMessages );
        
        foreach ($this->_messages as $m) {
            $output.='
            <p class="flashMessage">'.$m.'</p>';
        }
	  
	    return( '
	    <div class="flashMessages">'.$output.'</div>
	    ');
	    
	}
    
    private function _getMessages( $flashMessages )
    {
        if( is_array($flashMessages)){
            foreach ($flashMessages as $message) {
                $this->_getMessages($message);
            }
            return;
        }
        $this->_messages[] = $flashMessages;
    }

}
