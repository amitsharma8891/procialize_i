<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Super-simple, minimum abstraction MailChimp API v2 wrapper
 * 
 * Requires curl (I know, right?)
 * This probably has more comments than code.
 * 
 * @author Drew McLellan <drew.mclellan@gmail.com> modified by Ben Bowler <ben.bowler@vice.com>
 * @version 1.0
 */
class Generate_form
{
    public $ci;
    
    
/**
 *  generateHtml
 * 
 * generates admin panel form html 
 * pass the form element array and respective html is generated 
 * 
 * @access	public
 * @param	array formElements Elements of array
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */

    function generateFormHtml($formElements = array()) {
        $html = '';
        //if no form elements are passed
        if (empty($formElements))
            return $html;

        if ($formElements['fileUpload'])
            $html .= form_open_multipart($formElements['action'], $formElements['attributes']);
        else
            $html .= form_open($formElements['action'], $formElements['attributes']);
        foreach ($formElements['fields'] as $field) {
            $html .= getformElements($field);
        }
        $html .= formSubmitButtons();
        $html .= form_close();
        return $html;
    }

/**
 * getformElements
 * 
 * generates admin panel form html each element 
 * 
 * @access	public
 * @param	array $field Elements of array
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */
    function getformElements($field) {
        $html = '';
        if (empty($field))
            return $html;
        $type = $field['type'];
        switch ($type) {
            case 'text':
                $html = getformElementsText($field);
                break;
            default :
            case 'checkbox':
                $html = getformElementsChecbox($field);
                break;
            default :
                $html = getformElementsText($field);
        }
        return $html;
    }


/**
 * getformElementsChecbox
 * 
 * generates admin panel form html each element as textbox
 * 
 * @access	public
 * @param	array formElements Elements of array
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */

    function getformElementsChecbox($arrElement) {

        $html = '';
        if (empty($arrElement))
            return $html;

        $html .= '<div class="form-group">';
        $html .= '<label class="col-sm-2 control-label"> '.$arrElement['placeholder'] .' </label>';
        $html .= '<div class="col-sm-6">';
        $html .= form_checkbox($arrElement);
        $html .= "</div>";
        $html .= form_error($arrElement['name']);
        $html .= "</div>";
        return $html;
    }

/**
 * getformElementsText
 * 
 * generates admin panel form html each element as textbox
 * 
 * @access	public
 * @param	array formElements Elements of array
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */

    function getformElementsText($arrElement) {

        $html = '';
        if (empty($arrElement))
            return $html;

        $html .= '<div class="form-group">';
        $html .= '<label class="col-sm-2 control-label"> ' . $arrElement['placeholder'] . ' </label>';
        $html .= '<div class="col-sm-6">';
        $html .= form_input($arrElement);
        $html .= "</div>";
        $html .= form_error($arrElement['name']);
        $html .= "</div>";
        return $html;
    }

/**
 * formSubmitButtons
 * 
 * generates admin panel form html each element 
 * 
 * @access	public
 * @param	array $data Submit button paramas
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */

    function formSubmitButtons($data = array("name" => "btnSave", "value" => 1, "type" => "Submit", "id" => "btnSave", "content" => "Save", "class" => "btn btn-success btn-block")) {

        $html = '';
        $html .= '<div class="form-group">';
        $html .= '<div class="col-sm-4">';
        $html .= ' <input type="button" class="btn btn-danger btn-block" value="Cancel"/>';
        $html .= '</div>';
        $html .= '<div class="col-sm-4">';
        $html .= form_button($data);
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }




/**
 * formVaidation
 * 
 * Server side form validation
 * 
 * @access	public
 * @param	array formElements
 * @return	void
 * @author      Aatish Gore<aatish15@gmail.com>
 */

    function formVaidation($formElements) {
        if(empty($formElements))
            return;
        foreach($formElements as $element)
            $this->form_validation->set_rules($element['name'], $element['error'], $element['validate']);
       
    }
    
}