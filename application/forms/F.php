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
        $this->inlineElementDecorators  = array( 'ViewHelper', 'Errors', array('Description',array('escape' => false, 'class'=>"description")), array('content' => 'HtmlTag',array('tag' => 'span', 'class'=>'element')), array('Label',array('tag' => 'span', 'class'=>'label' )), array(array('row' => 'HtmlTag'), array('tag' => 'span', 'class' => 'inline')), );
        $this->buttonDecorators         = array( 'ViewHelper', array('HtmlTag',array('tag' => 'dd', 'class' => 'button')), array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => '')) );
        $this->hiddenDecorators         = array( 'ViewHelper', array('HtmlTag',array('tag' => 'span')), array(array('row' => 'HtmlTag'), array('tag' => 'span')) );
        $this->setAttrib('class','std');
        
        // Set the method for the display form to POST
        $this->setMethod('post');
        
        $this->questions=array(
        	"General: User's access is blocked/throttled, e.g. after having downloaded/uploaded a certain amount of data.	",
        	"General: Different priority levels within Internet access traffic             	",
        	"General: Restriction on the type of terminal allowed, or tiered pricing depending on the terminal used	",
        	"General: Other relevant practice	",
        	"Specific: P2P file sharing is blocked/throttled",
        	"Specific: VoIP is blocked/throttled",
        	"Specific: Instant Messaging services are blocked/throttled",
        	"Specific: Other specific kind of traffic port, protocol, application, usage, etc is blocked/throttled",
        	"Specific: Specific application/content provider e.g. website or VoIP provider is blocked/throttled",
            "Specific: Specific type of over-the-top traffic given preferential treatment e.g. specific content/application and/or specific application/content provider",
            "Other: Details in descriptions",
        );
        
        
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
                "Autriche", "Belgique", "Bulgarie", "Chypre", "République Tchèque", "Danemark", "Estonie", "Finlande", "France", "Allemagne", "Grèce", "Hongrie", "Islande", "Irlande", "Italie", "Lettonie", "Lituanie", "Luxembourg", "Malte", "Pays-Bas", "Norvège", "Pologne", "Portugal", "Roumanie", "Slovaquie", "Slovénie", "Espagne", "Suède", "Royaume-Uni"
                
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
                 array('Int'),
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
                'value'=>"Description"
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
                ),                
            ));
            // add the User deactivate element
            $this->addElement( 'select', $prefix."_d", array(
                "decorators"  => $this->inlineCheckboxDecorator,
                'required'    => true,
                'filters'     => array(
                    array('StripTags') 
                ),
                'validators'  => array(
                    array('StringLength', true, array('min'=>1,'max'=>16)),
                    array('Alnum', false, array('allowWhiteSpace'=>true))
                
                ),
                'multiOptions'=>array(
                    "empty"=>"Select... ",
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