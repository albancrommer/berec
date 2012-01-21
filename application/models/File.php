<?php
/**
* 
*/
class Default_Model_File
{
    protected $_data;
    
    function __construct( $data )
    {
        $this->_data = $data;
        $this->_rows=array("A","B","C");
    }
    
    public function get()
    {
        if( null == $this->_data ){
            throw( new Exception("Default_Model_File:get missing parameter : data."));}

        $cacheMethod    = PHPExcel_CachedObjectStorageFactory::cache_to_apc;
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod); 
        $objPHPExcel    = PHPExcel_IOFactory::load(APPLICATION_PATH."/../public/ec_berec_tm_questionnaire.xls"); 
        $objWorksheet   = $objPHPExcel->getActiveSheet(); 
        $access         = $this->_data['access'];
        $country        = $this->_data['country'];
        $isp            = $this->_data['isp'];
        $objWorksheet->setCellValue('B1', $access); 
        for ($i=0; $i < 3; $i++) { 
            $firstCell= 'row_'.$i.'_a';
            if(!$this->_data[$firstCell]){
                continue;
            }
            $row = $i+3;
            $objWorksheet->setCellValue("A$row", $country); 
            $objWorksheet->setCellValue("B$row", $isp); 
            $objWorksheet->setCellValue("C$row", $this->_data['row_'.$i.'_a']); 
            $objWorksheet->setCellValue("E$row", $this->_data['row_'.$i.'_b']); 
            $objWorksheet->setCellValue("I$row", $this->_data['row_'.$i.'_c']); 
            $objWorksheet->setCellValue("J$row", $this->_data['row_'.$i.'_d']); 
        }
        $dt             = microtime(true);
        $objWriter      =  PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $filename       = "BEREC-$dt.xls";
        $objWriter->save(APPLICATION_PATH."/../public/reports/".$filename);
        return $filename;
    }
}
