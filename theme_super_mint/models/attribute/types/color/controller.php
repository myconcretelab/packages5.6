<?php defined('C5_EXECUTE') or die(_("Access Denied."));
 
Loader::model('attribute/types/default/controller');
 
class ColorAttributeTypeController extends DefaultAttributeTypeController  {
 
   protected $searchIndexFieldDefinition = 'X NULL';
   
   public function getDisplayValue() {

      if (is_object($this->attributeValue)) {
         $value = $this->getAttributeValue()->getValue();
      } else {
         $value= '#ffffff';
      }
      
      $contrast = $this->get_contrast_color(substr($value,1,6));
      return "<span style='background:$value; padding:4px; color:#$contrast'>$value</span>";
   
   }
    
   public function form() {
      if (is_object($this->attributeValue)) {
         $value = $this->getAttributeValue()->getValue();
      }
      $fieldFormName = 'akID['.$this->attributeKey->getAttributeKeyID().'][value]';
      $html = '';
      $form = Loader::helper('form');
      $html .= '<div class="ccm-color-swatch-wrapper"><div class="ccm-color-swatch"><div id="f' . $this->attributeKey->getAttributeKeyHandle() . '" hex-color="' . $value . '" style="background-color:' . $value . '"></div></div></div>';
      $html .= $form->hidden($fieldFormName, $value);
 
      $html .= "<script type=\"text/javascript\">
   $(function() {
      var f" .$this->attributeKey->getAttributeKeyHandle(). "Div =$('div#f" .$this->attributeKey->getAttributeKeyHandle(). "');
      var c" .$this->attributeKey->getAttributeKeyHandle(). " = f" .$this->attributeKey->getAttributeKeyHandle(). "Div.attr('hex-color'); 
      f" .$this->attributeKey->getAttributeKeyHandle(). "Div.ColorPicker({
         color: c" .$this->attributeKey->getAttributeKeyHandle(). ",  
         onSubmit: function(hsb, hex, rgb, cal) { 
            $('input[name=" . '"akID['.$this->attributeKey->getAttributeKeyID().'][value]"' . "]').val('#' + hex);            
            $('div#f" . $this->attributeKey->getAttributeKeyHandle(). "').css('backgroundColor', '#' + hex); 
            cal.hide();
         },  
         onNone: function(cal) {  
            $('input[name=" . $fieldFormName . "]').val('');      
            $('div#f" . $this->attributeKey->getAttributeKeyHandle(). "').css('backgroundColor',''); 
         }
      });
 
   });
</script>";
      print $html;
   }

	function get_contrast_color($hex, $c = 120 ) {
	
	    $rgb = array(substr($hex,0,2), substr($hex,2,2), substr($hex,4,2));
	    
	    if(hexdec($rgb[0]) + hexdec($rgb[1]) + hexdec($rgb[2]) > 382){
	
	    }else{
	       $c = -$c;
	    }  
	    
	    for($i=0; $i < 3; $i++) :
	    
		if((hexdec( $rgb[$i]) - $c ) >= 0 )  :
	    
			$rgb[$i] = hexdec($rgb[$i]) - $c;
			$rgb[$i] = dechex($rgb[$i]);
			
			if(hexdec($rgb[$i]) <= 9) :
				$rgb[$i] = "0".$rgb[$i];
			elseif (hexdec($rgb[$i]) == 10 ) :
				$rgb[$i] = $rgb[$i] . $rgb[$i];
			endif;
	    
		else :
		    $rgb[$i] = "00";
		endif;
	      
	    endfor;
	    
	    return $rgb[0].$rgb[1].$rgb[2];
	}


}