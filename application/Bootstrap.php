<?php


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


    protected function _initParams()
    {
        Zend_Registry::set('contactemail', $this->getOption('contactemail'));
        Zend_Registry::set('contactname',$this->getOption('contactname'));
        Zend_Registry::set('webserveraddress',$this->getOption('webserveraddress'));
    }

    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
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
    
}

