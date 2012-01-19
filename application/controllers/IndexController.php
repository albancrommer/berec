<?php

require( APPLICATION_PATH.'/forms/F.php');

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $contextSwitch              = $this->_helper->getHelper('contextSwitch');

    }

    public function indexAction()
     {
         $this->_form = new Default_Form_F();

         if( $this->_request->isPost() ){
             if( $this->_form->isValid( $this->_request->getPost() ) ){
                 $this->_model->save();
                 $this->_flashMessenger->addMessage('Your report has been successfully saved.');
                 return $this->_redirect( $this->view->url(array('index','success'),null,true) );
             }
             else{
                 $errors = $this->_form->getMessages();
                 $this->setAjaxResponse("error",array("Invalid form",$errors));
                 $this->_form->populate($this->_request->getPost());
             } 
         }
         $this->view->form   = $this->_form;
         

     }

     public function successAction()
     {
         
     }
     
     public function faqAction()
     {
         
     }
     
     
     /**
      * Handles errors throwing in ajax context
      *
      * @param string $code 
      * @param string/array $messages 
      * @return void
      * @author Alban
      */
     public function setAjaxResponse($code = null, $messages = null)
     {
         if( null == $code ){
             throw( new Exception("IFO_Abstract_C:setAjaxResponse missing parameter : code."));}
         $this->view->code                       = $code;
         $this->setAjaxResponseMessages($messages);
     }

     /**
      * Deals with ajax response messages recursively by setting the view messages
      *
      * @param string/array $messages 
      * @return void
      * @author Alban
      */
     public function setAjaxResponseMessages($messages = null )
     {

         if( is_string($messages)){
             $messages[]            = $messages;
             $this->view->messages  = $messages;
         }
         else foreach ($messages as $key => $message) {
             $this->setAjaxResponseMessages($message);
         }

     }

     /**
      * Retrieves messages from model source 
      *
      * @param string $msg 
      * @return array of messages
      * @author Alban
      */
     public function getMessages($msg=null)
     {
         $messages=array();
         if(null!=$msg){
             $messages[]=$msg;
         }
         if( null != $this->_model->_messages ){
             $messages = array_merge($messages,$this->_model->_messages );
         }
         IFO_Log::debug("IFO_Abstract_C::getMessages ".print_r($messages,1));
         return $messages;
     }
 }

