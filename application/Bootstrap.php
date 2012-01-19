<?php


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


  	protected function _initDoctype()
    {
	    $this->bootstrap('view');
	    $view = $this->getResource('view');
	    $view->doctype('XHTML1_STRICT');
//		ZendX_JQuery::enableView($view);
    }

    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Brand_',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }

	function _initViewHelpers() {
		#
		$this->bootstrap('layout');
		#
		$layout = $this->getResource('layout');
		#
		$view = $layout->getView();
			#
		$view->addHelperPath(APPLICATION_PATH . '/views/helpers/', 'Default_View_Helper_');		
		#
	}

	function _initController()
	{

		$this->bootstrap('frontController');
		#
		$front = $this->getResource('frontController');
		#
		
		
	}
    protected function _initLog()
    {
        $app        = $this->getApplication();
        $dt         = time().microtime();
        $fileFilter = new Zend_Log_Filter_Priority(Zend_Log::DEBUG);
        $writer     = new Zend_Log_Writer_Stream(APPLICATION_PATH.'/../reports/'.$dt.'.csv');
        $writer->addFilter($fileFilter);
        $logger = new Zend_Log($redacteur);
        Zend_Registry::set('logger', $logger);
    }}

