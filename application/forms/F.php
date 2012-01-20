<?php

class Default_Form_F extends Zend_Form
{
    public $checkboxDecorator;
    public $buttonDecorators;
    public $elementDecorators;
    public $hiddenDecorators;
    public $inlineCheckboxDecorator;
    public $inlineElementDecorators;
    public $submitDecorators;
    
    public $rows=3;
    public $questions;
    public function init(){
         
        $this->checkboxDecorator        = array( 'ViewHelper', 'Errors', 'Description', array('content' => 'HtmlTag',array('tag' => 'dd', 'class'=>'checkbox')), array('Label',array('tag' => 'dt')), array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'row')) );
        $this->inlineCheckboxDecorator  = array( 'ViewHelper', 'Errors', 'Description', array('content' => 'HtmlTag',array('tag' => 'span', 'class'=>'checkbox')),  array(array('row' => 'HtmlTag'), array('tag' => 'span', 'class' => 'inline')), );
        $this->elementDecorators        = array( 'ViewHelper', 'Description', array('content' => 'HtmlTag',array('tag' => 'dd', 'class'=>'element')), array('Label',array('tag' => 'dt')), 'Errors', array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'row')) );         #
        $this->inlineElementDecorators  = array( 'ViewHelper', array('Description',array('escape' => false, 'class'=>"description")), array('content' => 'HtmlTag',array('tag' => 'span', 'class'=>'element')), 'Errors', array('Label',array('tag' => 'span', 'class'=>'label' )), array(array('row' => 'HtmlTag'), array('tag' => 'span', 'class' => 'inline')), );
        $this->buttonDecorators         = array( 'ViewHelper', array('HtmlTag',array('tag' => 'dd', 'class' => 'button')), array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => '')) );
        $this->hiddenDecorators         = array( 'ViewHelper', array('HtmlTag',array('tag' => 'span')), array(array('row' => 'HtmlTag'), array('tag' => 'span')) );
        $this->setAttrib('class','std');
        
        // Set the method for the display form to POST
        $this->setMethod('post');
        
        $this->questions=array(
            0=>"Select...",
            "General: User's access is blocked/throttled, e.g. after having downloaded/uploaded a certain amount of data."            
            =>"General: User's access is blocked/throttled, e.g. after having downloaded/uploaded a certain amount of data.",
        	"General: Different priority levels within Internet access traffic"
        	=>"General: Different priority levels within Internet access traffic",
        	"General: Restriction on the type of terminal allowed, or tiered pricing depending on the terminal used"
        	=>"General: Restriction on the type of terminal allowed, or tiered pricing depending on the terminal used",
        	"General: Other relevant practice"
        	=>"General: Other relevant practice",
        	"Specific: P2P file sharing is blocked/throttled"
        	=>"Specific: P2P file sharing is blocked/throttled",
        	"Specific: VoIP is blocked/throttled"
        	=>"Specific: VoIP is blocked/throttled",
        	"Specific: Instant Messaging services are blocked/throttled"
        	=>"Specific: Instant Messaging services are blocked/throttled",
        	"Specific: Other specific kind of traffic port, protocol, application, usage, etc is blocked/throttled"
        	=>"Specific: Other specific kind of traffic port, protocol, application, usage, etc is blocked/throttled",
        	"Specific: Specific application/content provider e.g. website or VoIP provider is blocked/throttled"
        	=>"Specific: Specific application/content provider e.g. website or VoIP provider is blocked/throttled",
            "Specific: Specific type of over-the-top traffic given preferential treatment e.g. specific content/application and/or specific application/content provider"
            =>"Specific: Specific type of over-the-top traffic given preferential treatment e.g. specific content/application and/or specific application/content provider",
            "Other: Details in descriptions"
            =>"Other: Details in descriptions",
        );
        
        
        // add the access element
        $this->addElement( 'select', 'access', array(
            'label'       =>"Type of network",
            "decorators"  => $this->elementDecorators,
            'required'    => true,
            'filters'     => array(
                array('StripTags') 
            ),
            'validators'  => array(
                array('StringLength', true, array('min'=>1,'max'=>64)),
            ),
            'multiOptions'=>array(
                "fixed"=>"Fixed Internet (ADSL)",
                "mobile"=>"Mobile Internet"
            )
        ));
        
        // add the country element
        $this->addElement( 'select', 'country', array(
            'label'       =>"Country",
            "decorators"  => $this->elementDecorators,
            'required'    => true,
            'filters'     => array(
                array('StripTags') 
            ),
            'validators'  => array(
                array('StringLength', true, array('min'=>1,'max'=>64)),
            ),
            'multiOptions'=>array(
                "Austria"=>"Austria",
                "Belgium"=>"Belgium",
                "Bulgaria"=>"Bulgaria",
                "Cyprus"=>"Cyprus",
                "Czech Republic"=>"Czech Republic",
                "Denmark"=>"Denmark",
                "Estonia"=>"Estonia",
                "Finland"=>"Finland",
                "France"=>"France",
                "Germany"=>"Germany",
                "Greece"=>"Greece",
                "Hungary"=>"Hungary",
                "Iceland"=>"Iceland",
                "Ireland"=>"Ireland",
                "Italy"=>"Italy",
                "Latvia"=>"Latvia",
                "Lithuania"=>"Lithuania",
                "Luxembourg"=>"Luxembourg",
                "Malta"=>"Malta",
                "Netherlands"=>"Netherlands",
                "Norway"=>"Norway",
                "Poland"=>"Poland",
                "Portugal"=>"Portugal",
                "Romania"=>"Romania",
                "Slovakia"=>"Slovakia",
                "Slovenia"=>"Slovenia",
                "Spain"=>"Spain",
                "Sweden"=>"Sweden",
                "United Kingdom"=>"United Kingdom"
            )
        ));
        
        // add the isp element
        $this->addElement( 'text', 'isp', array(
            'label'       =>"Your ISP",
            "decorators"  => $this->elementDecorators,
            'required'    => true,
            'filters'     => array(
                array('StripTags') 
            ),
            'validators'  => array(
                array('StringLength', true, array('min'=>1,'max'=>64)),
                // array('Int')
                // array('Alnum', false, array('allowWhiteSpace'=>true))
                
            )
        ));
        
        
        $this->addRows();
        
        // add the submit element
        $this->addElement( 'submit', 'submit', array(
            'label'       =>"Send",
            "decorators"  => $this->buttonDecorators,
            'required'    => true,
            'filters'     => array(
                array('StripTags') 
            ),
            'validators'  => array(
                array('StringLength', true, array('min'=>1,'max'=>16)),
                
        )));
    
    
        $this->setDefaultDisplayGroupClass('row');
        
        $this->setDisplayGroupDecorators(array(
            "FormElements","Fieldset"
        ));
    }
    
    public function addRows()
    {
        for ($i=0; $i < $this->rows; $i++) { 
            $prefix="row_$i";
        
        
            $this->addElement( "select", $prefix."_a", array(
                "decorators"    => $this->inlineElementDecorators, 
                "required"      => true,
                "filters"       => array(
                  array('StripTags') 
                ),
                "validators"       => array(
                 // array('Int'),
                ),
                "multiOptions"  => $this->questions
            ));    

            // add the desc element
            $this->addElement( 'textarea', $prefix."_b", array(

                "decorators"  => $this->inlineElementDecorators,
                'required'    => true,
                'filters'     => array(
                    array('StripTags') 
                ),
                'validators'  => array(
                    array('StringLength', true, array('min'=>1,'max'=>512)),
                ),
                'attribs'=>array(
                    "cols"=>20,
                    "rows"=>5
                ),
                'value'=>"{Describe how this works}"
            ));
        
            // add the User informed element
            $this->addElement( 'textarea', $prefix."_c", array(
                "decorators"  => $this->inlineElementDecorators,
                'required'    => false,
                'filters'     => array(
                    array('StripTags') 
                ),
                'validators'  => array(
                    array('StringLength', true, array('min'=>1,'max'=>512)),
                ),
                'attribs'=>array(
                    "cols"=>20,
                    "rows"=>5
                )    ,
                'value'=>"{Describe how you were informed: did your ISP explain for example?}"
            ));
            // add the User deactivate element
            $this->addElement( 'select', $prefix."_d", array(
                "decorators"  => $this->inlineCheckboxDecorator,
                'required'    => false,
                'filters'     => array(
                    array('StripTags') 
                ),
                'validators'  => array(
                    array('StringLength', true, array('min'=>1,'max'=>16)),
                    array('Alnum', false, array('allowWhiteSpace'=>true))
                
                ),
                'multiOptions'=>array(
                    " "=>"Select... ",
                    "yes"=>"yes",
                    "no"=>"no"
                )
            
            ));
        
        
            $this->addDisplayGroup(array(
                $prefix."_a",
                $prefix."_b",
                $prefix."_c",
                $prefix."_d",

            ),$prefix."_group");
        }
    }
    
    public function addOptionalDisplayGroups( $elementsArray = null )
    {
        if(count($elementsArray) == 0){
            return;
        }
        foreach ( $elementsArray as $key => $value) {

            $this->addDisplayGroup($value,$key);
        }

    }
    
    public function removeOptionalElements( $elementsArray = null )
    {
        if(count($elementsArray) == 0){
            return;
        }
        foreach ( $elementsArray as $key => $value) {
            $this->removeElement( $key );    
        }

    }
}