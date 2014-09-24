<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Procialize
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Procialize
 * @author		Aatish Gore
 * @copyright           Copyright (c) 2013 - 2014.
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Custom form helper
 *
 * @package		JITO
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Aatish Gore
 */
// ------------------------------------------------------------------------

/**
 * Element
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns FALSE (or whatever you specify as the default value.)
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	mixed
 * @return	mixed	depends on what the array contains
 */
/**
 * generateHtml
 * 
 * generates admin panel form html 
 * pass the form element array and respective html is generated 
 * 
 * @access	public
 * @param	array formElements Elements of array
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('generateFormHtml')) {

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

}

/**
 * generateSearchFormHtml
 * 
 * generates admin panel form html 
 * pass the form element array and respective html is generated 
 * 
 * @access	public
 * @param	array formElements Elements of array
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('generateSearchFormHtml')) {

    function generateSearchFormHtml($formElements = array()) {
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
        $html .= formSearchButtons();
        $html .= form_close();

        return $html;
    }

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
if (!function_exists('getformElements')) {


    function getformElements($field) {
        $html = '';
        if (empty($field))
            return $html;
        $type = $field['type'];
        switch ($type) {
            case 'text':
                $html = getformElementsText($field);
                break;
			case 'textarea':
                $html = getformElementsTextArea($field);
                break;
            case 'password':
                $html = getformElementsPassword($field);
                break;
            case 'checkbox':
                $html = getformElementsChecbox($field);
                break;
            case 'radio':
                $html = getformElementsRadio($field);
                break;
            case 'dropdown':
                $html = getformElementsDropdown($field);
                break;
            case 'hidden':
                $html = getformElementsHidden($field);
                break;
            case 'file':
                $html = getformElementsFile($field);
                break;
            default :
                $html = getformElementsText($field);
        }

        return $html;
    }

}

/**
 * getValidationErrors
 * 
 * generates validation error
 * 
 * @access	public
 * @param	null
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('getValidationErrors')) {


    function getValidationErrors() {
        $html = '';
        $html = validation_errors();
        return $html;
    }

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
if (!function_exists('getformElementsChecbox')) {

    function getformElementsChecbox($arrElement) {

        $html = '';
        if (empty($arrElement))
            return $html;

        $arrDecorators = array();
        $arrDecorators = generateDecorators($arrElement);
        if (!empty($arrDecorators)) {

            unset($arrElement['decorators']);
            $html .= $arrDecorators['start'];
            if (is_array($arrElement['placeholder'])) {
                $arrLabel = $arrElement['placeholder'];
                unset($arrElement['placeholder']);
                $arrChecked = array();
                if (isset($arrElement['checked']))
                    $arrChecked = explode(',', $arrElement['checked']);
                    unset($arrElement['checked']);
                    $html .= '<ul class="list-inline mb5">';
                foreach ($arrLabel as $key => $placeholder) {
                    $checked = FALSE;
                    if (in_array($key, $arrChecked))
                        $checked = TRUE;
                    $html .= '<li>';
                    $data = 'id='.$placeholder;
                    $html .= form_checkbox($placeholder, $key, $checked,$data);
                    $html .= "<label>" . $placeholder . "</label>";
                    $html .= '</li>';
                }
                $html .= '</ul >';
            } else {
                $checked = false;
                if (isset($arrElement['checked'])) {
                    if ($arrElement['checked'])
                        $checked = true;
                    unset($arrElement['checked']);
                }
                $html .= form_checkbox($arrElement, isset($arrElement['value']) ? $arrElement['value'] : '', $checked);
                $html .= "<span>" . $arrElement['placeholder'] . "</span>";
            }


            $html .= $arrDecorators['end'];
            return $html;
        }

        $html .= '<div class="form-group">';
        $html .= '<label class="col-sm-2 control-label"> ' . $arrElement['placeholder'] . ' </label>';
        $html .= '<div class="col-sm-6">';
        $html .= form_checkbox($arrElement);
        $html .= "</div>";
        $html .= form_error($arrElement['name']);
        $html .= "</div>";
        return $html;
    }

}

/**
 * getformElementsRadio
 * 
 * generates admin panel form html each element as radio button
 * 
 * @access	public
 * @param	array formElements Elements of array
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('getformElementsRadio')) {

    function getformElementsRadio($arrElement) {

        $html = '';
        if (empty($arrElement))
            return $html;
        $checked = false;
        $checkedValue = '';
        if (isset($arrElement['checked'])) {
            $checkedValue = $arrElement['checked'];
            unset($arrElement['checked']);
        }
        $arrDecorators = array();
        $arrDecorators = generateDecorators($arrElement);
        if (!empty($arrDecorators)) {

            unset($arrElement['decorators']);
            $html .= $arrDecorators['start'];

            $arrLabel = $arrElement['placeholder'];
            unset($arrElement['placeholder']);
            foreach ($arrLabel as $key => $placeholder) {
                $checked = false;
                if ($key == $checkedValue)
                    $checked = true;

                $html .= "<div class='radio-button-holder'>" . form_radio($arrElement, $key, $checked) . "</div>";
                $html .= "<div class='radio-button-holder-label'>" . $placeholder . "</div>";
            }
            $html .= $arrDecorators['end'];
            return $html;
        }

        $html .= '<div class="form-group">';
        $html .= '<label class="col-sm-2 control-label"> ' . $arrElement['placeholder'] . ' </label>';
        $html .= '<div class="col-sm-6">';
        $html .= form_checkbox($arrElement);
        $html .= "</div>";
        $html .= form_error($arrElement['name']);
        $html .= "</div>";
        return $html;
    }

}


/**
 * getformElementsDropdown
 * 
 * generates admin panel form html each element as textbox
 * 
 * @access  public
 * @param   array formElements Elements of array
 * @return  string $html    generated Html
 * @author     Rohan <rohanbpatil77@gmail.com>
 */
if (!function_exists('getformElementsDropdown')) {

    function getformElementsDropdown($arrElement) {
        $html = '';
        if (empty($arrElement))
            return $html;
        if (isset($arrElement['value'])) {
            $selected = $arrElement['value'];
        } else {
            $selected = '';
        }
        $arrDecorators = generateDecorators($arrElement);
        if (!empty($arrDecorators)) {

            unset($arrElement['decorators']);
            $html .= $arrDecorators['start'];
            $attributes = '';
            //print_r($arrElement);exit;
            if (isset($arrElement['class'])) {
                $class = " class='" . $arrElement['class'] . "' ";
                $attributes .= $class;
            }
            if (isset($arrElement['attributes']))
                $attributes .= ' ' . $arrElement['attributes'];
            $html .= form_dropdown($arrElement['name'], $arrElement['options'], $selected, $attributes);
            $html .= $arrDecorators['end'];
            return $html;
        }

        $html .= '<div class="form-group">';
        $html .= '<label class="col-sm-2 control-label"> ' . $arrElement['placeholder'] . ' </label>';
        $html .= '<div class="col-sm-6">';
        $html .= form_dropdown($arrElement['name'], $arrElement['options'], $selected);
        $html .= "</div>";
        $html .= form_error($arrElement['name']);
        $html .= "</div>";
        return $html;
    }

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
if (!function_exists('getformElementsText')) {

    function getformElementsText($arrElement) {
        $html = '';

        if (empty($arrElement))
            return $html;
        $arrDecorators = array();
        $arrDecorators = generateDecorators($arrElement);
        if (!empty($arrDecorators)) {

            unset($arrElement['decorators']);
            $html .= $arrDecorators['start'];
            $html .= form_input($arrElement);
            $html .= $arrDecorators['end'];
            return $html;
        }
        $html .= '<div class="form-group">';
        $html .= '<label class="col-sm-2 control-label"> ' . $arrElement['placeholder'] . ' </label>';
        $html .= '<div class="col-sm-6">';
        $html .= form_input($arrElement);
        $html .= "</div>";
        $html .= form_error($arrElement['name']);
        $html .= "</div>";
        return $html;
    }

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
if (!function_exists('getformElementsTextArea')) {

    function getformElementsTextArea($arrElement) {
        $html = '';

        if (empty($arrElement))
            return $html;
        $arrDecorators = array();
        $arrDecorators = generateDecorators($arrElement);
        if (!empty($arrDecorators)) {

            unset($arrElement['decorators']);
            $html .= $arrDecorators['start'];
            $html .= form_textarea($arrElement);
            $html .= $arrDecorators['end'];
            return $html;
        }
        $html .= '<div class="form-group">';
        $html .= '<label class="col-sm-2 control-label"> ' . $arrElement['placeholder'] . ' </label>';
        $html .= '<div class="col-sm-6">';
        $html .= form_textarea($arrElement);
        $html .= "</div>";
        $html .= form_error($arrElement['name']);
        $html .= "</div>";
        return $html;
    }

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
if (!function_exists('getformElementsFile')) {

    function getformElementsFile($arrElement) {
        $html = '';

        if (empty($arrElement))
            return $html;
        unset($arrElement['upload_config']);
        $arrDecorators = array();
        $arrDecorators = generateDecorators($arrElement);
        if (!empty($arrDecorators)) {

            unset($arrElement['decorators']);
            $html .= $arrDecorators['start'];
            $html .= form_upload($arrElement);
            $html .= $arrDecorators['end'];
            return $html;
        }
        $html .= '<div class="form-group">';
        $html .= '<label class="col-sm-2 control-label"> ' . $arrElement['placeholder'] . ' </label>';
        $html .= '<div class="col-sm-6">';
        $html .= form_upload($arrElement);
        $html .= "</div>";
        $html .= form_error($arrElement['name']);
        $html .= "</div>";
        return $html;
    }

}
/**
 * getformElementsHidden
 * 
 * generates admin panel form html each element as hidden
 * 
 * @access	public
 * @param	array formElements Elements of array
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('getformElementsHidden')) {

    function getformElementsHidden($arrElement) {
        $html = '';

        if (empty($arrElement))
            return $html;
        $arrDecorators = array();
        $arrDecorators = generateDecorators($arrElement);

        if (!empty($arrDecorators)) {
            unset($arrElement['decorators']);
            unset($arrElement['type']);
            $html .= $arrDecorators['start'];
            $html .= form_hidden($arrElement);
            $html .= $arrDecorators['end'];
        } else {

            unset($arrElement['decorators']);
            unset($arrElement['type']);
            $html .= form_hidden($arrElement);
        }
        return $html;
    }

}
/**
 * getformElementsPassword
 * 
 * generates admin panel form html each element as password
 * 
 * @access	public
 * @param	array formElements Elements of array
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('getformElementsPassword')) {

    function getformElementsPassword($arrElement) {
        $html = '';

        if (empty($arrElement))
            return $html;
        $arrDecorators = array();
        $arrDecorators = generateDecorators($arrElement);
        if (!empty($arrDecorators)) {

            unset($arrElement['decorators']);
            $html .= $arrDecorators['start'];
            $html .= form_password($arrElement);
            $html .= $arrDecorators['end'];
            return $html;
        }
        $html .= '<div class="form-group">';
        $html .= '<label class="col-sm-2 control-label"> ' . $arrElement['placeholder'] . ' </label>';
        $html .= '<div class="col-sm-6">';
        $html .= form_password($arrElement);
        $html .= "</div>";
        $html .= form_error($arrElement['name']);
        $html .= "</div>";
        return $html;
    }

}

function generateDecorators($arrDecorators) {
    $html = array("start" => "", "end" => "");

    if (empty($arrDecorators['decorators']))
        return $html;
    foreach ($arrDecorators['decorators'] as $decorator) {
        $startHtml = "";
        $endHtml = "";


        if (isset($decorator['position'])) {

            $type = $decorator['position'];
            $tag = $decorator['tag'];
            $class = $decorator['class'];
            $content = $decorator['content'];
            switch ($type) {
                case 'appendElement':
                    $appendContent = generateHtmlTag($tag, $class) . $content . generateHtmlTag($tag, '', '', true);
                    $endHtml = $appendContent;
                    $html['start'] .= $startHtml;
                    $html['end'] = $endHtml . $html['end'];
                    break;
                case 'prependElement':
                    $appendContent = generateHtmlTag($tag, $class) . $content . generateHtmlTag($tag, '', '', true);
                    $startHtml = $appendContent;
                    $html['start'] .= $startHtml;
                    $html['end'] .= $endHtml;
                    break;
                case 'prependOuter':

                    $appendContent = generateHtmlTag($tag, $class) . $content . generateHtmlTag($tag, '', '', true);
                    $html['start'] .= $startHtml;
                    $html['start'] = $appendContent . $html['start'];
                    $html['end'] .= $endHtml;
                    break;
                case 'appendOuter':

                    $appendContent = generateHtmlTag($tag, $class) . $content . generateHtmlTag($tag, '', '', true);
                    $html['start'] .= $startHtml;
                    $html['end'] .= $endHtml;
                    $html['end'] = $html['end'] . $appendContent;

                    break;
            }
        } else {
            if ($decorator['close'] != 'close') {
                $startHtml .= openTag($decorator);
                if ($decorator['close'] == "true") {
                    $endHtml .= closeTag($decorator) . $endHtml;
                }
            } else {
                $endHtml .= closeTag($decorator);
            }

            $html['start'] .= $startHtml;
            $html['end'] .= $endHtml;
        }
		if(isset($decorator['tag_data_close'])){
			/*var_dump($decorator);
			var_dump($html);exit;
*/		}
    }
	
	
    return $html;
}

function openTag($decorator) {

    $tag = $decorator['tag'];
    $class = (isset($decorator['class']) ? $decorator['class'] : '');
    $attribute = (isset($decorator['attribute']) ? $decorator['attribute'] : '');
	$content = (isset($decorator['tag_data']) ? $decorator['tag_data'] : '');
    $html = "<$tag  class='$class'  $attribute >";
	
	
    $html = generateHtmlTag($tag, $class, $attribute);
	$html .= $content;
    return $html;
}

function generateHtmlTag($tag = 'div', $class = '', $attribute = '', $close = FALSE) {
    if ($close)
        $html = '</' . $tag . '>';
    else
        $html = "<$tag  class='$class'  $attribute >";

    return $html;
}

function closeTag($decorator) {
    $tag = $decorator['tag'];
	 $content = (isset($decorator['tag_data_close']) ? $decorator['tag_data_close'] : '');
    $html = $content.generateHtmlTag($tag, '', '', TRUE);
	
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
if (!function_exists('formSubmitButtons')) {

    function formSubmitButtons($data = array("name" => "btnSave", "value" => 1, "type" => "Submit", "id" => "btnSave", "content" => "Submit", "class" => "btn btn-success btn-block")) {

        $html = '';
        $html .= '<div class="form-group">';
        $html .= '<div class="col-sm-4" id="cancel_button">';
        $html .= ' <input type="button" class="btn btn-danger btn-block" value="Cancel" />';
        $html .= '</div>';
        $html .= '<div class="col-sm-4">';
        $html .= form_button($data);
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}


/**
 * formSearchButtons
 * 
 * generates admin panel form html each element 
 * 
 * @access	public
 * @param	array $data Submit button paramas
 * @return	string $html	generated Html
 * @author      Aatish Gore<aatish15@gmail.com>
 */
if (!function_exists('formSearchButtons')) {

    function formSearchButtons($data = array("name" => "btnSave", "value" => 1, "type" => "Submit", "id" => "btnSave", "content" => "Search", "class" => "btn btn-success btn-block")) {

        $html = '';
        $html .= '<div class="col-sm-4">';
        $html .= form_button($data);
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

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
if (!function_exists('formVaidation')) {

    function formVaidation($formElements, $ci) {
        if (empty($formElements))
            return;

        foreach ($formElements['fields'] as $element) {
//            echo '<pre>';
//        var_dump($element);
//        echo '</pre>';
//        
            if (isset($element['validate'])) {
                $ci->form_validation->set_rules($element['name'], $element['error'], $element['validate']);
            }
        }
    }

}


/**
 * getTopLevelId
 * 
 * returns TopLevelId
 * 
 * @access  public
 * @param   array 
 * @return  void
 * @author   Rohan <rohanbpatil77@gmail.com>
 */
if (!function_exists('getTopLevelId')) {

    function getTopLevelId() {
        return 1;
        /* For time being it is returning 1 */
    }

}

/**
 * getPrivateOrgId
 * 
 * returns PrivateOrgId
 * 
 * @access  public
 * @param   array 
 * @return  void
 * @author   Rohan <rohanbpatil77@gmail.com>
 */
if (!function_exists('getPrivateOrgId')) {

    function getPrivateOrgId() {
        return 1;
        /* For time being it is returning 1 */
    }

}

/**
 * getOrganizerId
 * 
 * returns OrganizerId
 * 
 * @access  public
 * @param   array 
 * @return  void
 * @author   Rohan <rohanbpatil77@gmail.com>
 */
if (!function_exists('getOrganizerId')) {

    function getOrganizerId() {
        return 1;
        /* For time being it is returning 1 */
    }

}
