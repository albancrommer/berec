<?php

require( APPLICATION_PATH.'/forms/F.php');
require( APPLICATION_PATH.'/models/File.php');
require( APPLICATION_PATH.'/../library/Zend/Controller/Action/Helper/FlashMessenger.php');

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $contextSwitch              = $this->_helper->getHelper('contextSwitch');
        $this->_flashMessenger          = $this->_helper->getHelper('FlashMessenger');

    }

    public function indexAction()
     {
         $this->_form = new Default_Form_F();

         if( $this->_request->isPost() ){
             if( $this->_form->isValid( $this->_request->getPost() ) ){
                 
                 if( $this->_request->getPost('row_0_a')
                 || $this->_request->getPost('row_1_a')
                 || $this->_request->getPost('row_2_a')
                 ){
                     
                     $data      = $this->_form->getValues();
                     $model     = new Default_Model_File( $data );
                     $filename  = $model->get();
                     $file      = file_get_contents(APPLICATION_PATH."/../reports/".$filename);

                     // $filename  = $dt.'.csv';
                     // $fileFilter = new Zend_Log_Filter_Priority(Zend_Log::DEBUG);
                     // $writer    = new Zend_Log_Writer_Stream(APPLICATION_PATH.'/../reports/'.$filename);
                     // $writer->addFilter($fileFilter);
                     // $logger    = new Zend_Log($writer);
                     // $logger->info($file);
                 
                 
                     if( APPLICATION_ENV == "development" ){
                         $tr    = new Zend_Mail_Transport_Smtp("smtp.free.fr");
                         Zend_Mail::setDefaultTransport($tr);
                     }
                     // mail
                     $mailer            = new Zend_Mail();
                     $at                = $mailer->createAttachment($file);
                     $at->disposition   = Zend_Mime::DISPOSITION_ATTACHMENT;
                     $at->encoding      = Zend_Mime::ENCODING_BASE64;
                     $at->type          ="application/excel";
                     $at->filename      = $filename;
                     $mailer->SetBodyText("New report ")
                         ->SetFrom(Zend_Registry::get('contactemail'),Zend_Registry::get('contactname'))
                         ->AddTo(Zend_Registry::get('contactemail'),Zend_Registry::get('contactname'))
                         ->setSubject("New #nnmon report")
                         ->send();
                 
                     $this->_flashMessenger->addMessage('Your report has been successfully saved.');
                     // return $this->_redirect( $this->view->url(array("controller"=>'index',"action"=>'success'),null,true) );
                     
                     }
                     else{
                         $this->setAjaxResponse("error",array("You must submit at least one case",$errors));
                         $this->_form->populate($this->_request->getPost());
                         $this->view->edit = 1;
                     }
             }
             else{
                 $errors = $this->_form->getMessages();
                 $this->setAjaxResponse("error",array("Invalid form",$errors));
                 $this->_form->populate($this->_request->getPost());
                 $this->view->edit = 1;
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
     
     public function howtoAction()
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
             $ar[]                  = $messages;
             $this->view->messages  = $ar;
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

