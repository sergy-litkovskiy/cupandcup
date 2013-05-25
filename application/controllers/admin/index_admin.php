<?php
/**
 * @author Litkovskiy
 * @copyright 2010
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_admin extends CI_Controller
{
    public $arrMenu             = array();
    public $emptyArticleArr     = array();
    public $subscribe           = array();
    public $emptyAforizmusArr   = array();
    public $defaultDescription  = '';
    public $defaultKeywords     = '';
    public $message;
    private $tableName;

    public function __construct()
    {
       parent::__construct();

       if(!$this->session->userdata('username') && !$this->session->userdata('loggedIn')){
           $this->login_model->logOut();
       }
       $this->message          = null;
       $this->arrMenu          = $this->_prepareMenu();
       $this->result           = array("success" => true, "message" => null, "data" => null);
       $this->emptyMenuArr  = array(
                        'id'                => null
                       ,'slug'              => null
                       ,'text'              => null
                       ,'title'             => null
                       ,'num_sequence'      => null
                       ,'status'            => null
                       ,'seo_description'   => null
                       ,'seo_keywords'      => null
                       ,'seo_title'         => null);

       
       $this->urlArr = explode('/',$_SERVER['REQUEST_URI']);   
    }



    public function index()
    {
       $this->data_arr      = array('title'     => 'Color - admin'
                                    , 'menu'    => $this->arrMenu
                                    , 'form_menu_edit_new' => $this->load->view('admin/blocks/form_edit_menu_new', '', true));
       $data = array(
                'menu'          => $this->load->view(MENU_ADMIN, '', true),
                'content'       => $this->load->view('admin/index_admin/show', $this->data_arr, true));

       $this->load->view('layout_admin', $data);
    }



    public function show_catalog()
    {
//       $this->data_menu      = array('menu' => $this->arrMenu);
       $catalogArr           = $this->_prepareCatalog();

       $this->data_arr       = array(
             'title'              => 'Color - edit catalog'
            ,'content'            => $catalogArr
            ,'catalog_container'  => $this->load->view('admin/blocks/catalog_container', '', true)
       );
       
       $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/catalog_admin/show', $this->data_arr, true));

       $this->load->view('layout_admin', $data);
    }
    
    
    
    public function show_gallery()
    {
        $content    = $this->index_model->getFromTableByParams(array('status' => STATUS_ON), 'gallery');
$this->firephp->fb($content);
        $this->data_arr     = array(
                'title'     => 'Редактировать Галерею'
                ,'content'  => $content
        );

        $data = array(
                    'menu'          => $this->load->view(MENU_ADMIN, '', true),
                    'content'       => $this->load->view('admin/index_admin/gallery', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
////////////////////////////////MENU//////////////////////////
    public function ajax_menu_edit()
    {
        try{
            $this->tryAddOrUpdateMenu();
            $this->result['data'] = SUCCESS_MESS;
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }

    

    public function tryAddOrUpdateMenu()
    {
        $params ['table']   = 'menu';
        $this->_formValidation();
        $id     = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
        $data   = $this->_prepareMenuDataForAddUpdate($_REQUEST);

        if($id){
            $params ['id'] = $id;
            $dataUpdate = array('num_sequence'    => $_REQUEST['num_sequence']
                                ,'status'         => $_REQUEST['status']);
            $data = array_merge($data, $dataUpdate);

            $this->_update($data, $params);
        } else {
            $dataAdd = array('num_sequence'    => '0'
                            ,'status'          => STATUS_ON);
            $data   = array_merge($data, $dataAdd);
            $id     = $this->_add($data, $params);
            Common::assertTrue($id, 'Ошибка! К сожалению, раздел не был добавлен. Попробуйте ще раз');
        }
           
    }

    

    private function _formValidation()
    {
        $rules = $this->_prepareMenuValidationRules();
        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }



    private function _prepareMenuValidationRules()
    {
        return array(
                    array(
    		        'field'	=> 'title',
    		    	'label'	=> '<Название раздела>',
    		    	'rules'	=> 'required')
                    ,array(
    		        'field'	=> 'slug',
    		    	'label'	=> '<Алиас раздела>',
    		    	'rules'	=> 'required'));
    }



    private function _prepareMenuDataForAddUpdate($request)
    {
        return array('seo_description'  => $request['seo_description']
                    ,'seo_keywords'     => $request['seo_keywords']
                    ,'seo_title'        => $request['seo_title']
                    ,'title'            => $request['title']
                    ,'slug'             => $request['slug']
                    ,'description'      => $request['description']
                    ,'num_sequence'     => $request['num_sequence']);
    }
    
    
    
    public function ajax_menu_delete_item()
    {
        try{
            $this->tableName = 'menu';
            $this->tryDeleteMenuItem();
            $this->result['data'] = SUCCESS_MESS;
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
    
    
    
    public function tryDeleteMenuItem()
    {
        $params['table']  = $this->tableName;
        $params['id']     = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
        Common::assertTrue($params['id'], 'Ошибка! Не установлен идентификатор раздела для удаления');
        
        $result = $this->_dropInTable($params);
        Common::assertTrue($result, 'Ошибка! К сожалению, раздел не был удален. Попробуйте ще раз');
    }
    

        
    public function ajax_menu_change_status_item()
    {
        $this->tableName = 'menu';
        $this->_ajaxChangeStatus();
    }

    
        
    public function ajax_gallery_change_status_item()
    {
        $this->tableName = 'gallery';
        $this->_ajaxChangeStatus();
    }
    
    
    
    private function _ajaxChangeStatus()
    {
        try{
            $this->_tryChangeStatus();
            $this->result['data'] = SUCCESS_MESS;
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
    

    
    private function _tryChangeStatus()
    {
        $params['table']  = $this->tableName;
   
        $params['id']     = isset($_REQUEST['menuItemId']) && $_REQUEST['menuItemId'] ? $_REQUEST['menuItemId'] : null;
        Common::assertTrue($params['id'], 'Ошибка! Не установлен идентификатор раздела для изменения статуса');
        
        $data['status']     = isset($_REQUEST['itemStatus']) && $_REQUEST['itemStatus'] ? $_REQUEST['itemStatus'] : null;
        
        $result = $this->_updateInTable($data, $params);
        Common::assertTrue($result, 'Ошибка! К сожалению, статус не был изменен. Попробуйте ще раз');
    }
    
    
    
    public function ajax_menu_change_position_item()
    {
        try{
            $this->tryChangePositionMenuItem();
            $this->result['data'] = SUCCESS_MESS;
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
    
    
        
    public function tryChangePositionMenuItem()
    {
        $params['table']  = 'menu';
        $this->db->trans_start();
        
        $this->_updateCurrentPosition($params);
        $this->_updateBesidePosition($params);
        
        $this->db->trans_complete();
    }
    
    
    
    private function _updateCurrentPosition($params)
    {
        $params['id']     = isset($_REQUEST['currMenuItemId']) && $_REQUEST['currMenuItemId'] ? $_REQUEST['currMenuItemId'] : null;
        Common::assertTrue($params['id'], 'Ошибка! Не установлен идентификатор раздела для изменения порядкового номера');
        
        $data['num_sequence']   = isset($_REQUEST['currNumSequence']) && $_REQUEST['currNumSequence'] ? $_REQUEST['currNumSequence'] : null;
        
        $result = $this->_updateInTable($data, $params);
        Common::assertTrue($result, 'Ошибка! К сожалению, статус не был изменен. Попробуйте ще раз');            
    }
    
    
    
    private function _updateBesidePosition($params)
    {
        $params['id']     = isset($_REQUEST['besideMenuItemId']) && $_REQUEST['besideMenuItemId'] ? $_REQUEST['besideMenuItemId'] : null;
        Common::assertTrue($params['id'], 'Ошибка! Не установлен идентификатор ближайшего раздела для изменения порядкового номера');      
        
        $data['num_sequence']   = isset($_REQUEST['besideNumSequence']) && $_REQUEST['besideNumSequence'] ? $_REQUEST['besideNumSequence'] : null;
        
        $result = $this->_updateInTable($data, $params);
        Common::assertTrue($result, 'Ошибка! К сожалению, статус не был изменен. Попробуйте ще раз'); 
    }
    
////////////////////////////////CATALOG//////////////////////////
    public function ajax_catalog_edit()
    {
        try{
            $this->tryAddOrUpdateCatalog();
            $this->result['data'] = SUCCESS_MESS;
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }

    

    public function tryAddOrUpdateCatalog()
    {
        $data = array();
        $this->_formCatalogValidation();
        
        $productsId     = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
        $propertiesId   = isset($_REQUEST['properties_id']) && $_REQUEST['properties_id'] ? $_REQUEST['properties_id'] : null;
        
        $data['products']   = $this->_prepareProductsDataForAddUpdate($_REQUEST);
        $propertiesImgData  = $this->_preparePropertiesImgDataForAddUpdate($_REQUEST);
        $data['properties'] = array_merge($propertiesImgData, $this->_preparePropertiesDataForAddUpdate($_REQUEST));
        
        if($productsId && $propertiesId){
            $data['products']['id']     = $productsId;
            $data['properties']['id']   = $propertiesId;
            $data['properties']['products_id'] = $productsId;

            $this->index_model->updateCatalog($data);
        } else {
            $this->index_model->addCatalog($data);
        }
    }

    

    private function _formCatalogValidation()
    {
        $rules = $this->_prepareCatalogValidationRules();
        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }



    private function _prepareCatalogValidationRules()
    {
        return array(
                    array(
    		        'field'	=> 'title',
    		    	'label'	=> '<Название раздела>',
    		    	'rules'	=> 'required')
                    ,array(
    		        'field'	=> 'slug',
    		    	'label'	=> '<Алиас раздела>',
    		    	'rules'	=> 'required'));
    }



    private function _prepareProductsDataForAddUpdate($request)
    {
        return array('seo_description'  => $request['seo_description']
                    ,'seo_keywords'     => $request['seo_keywords']
                    ,'seo_title'        => $request['seo_title']
                    ,'title'            => $request['title']
                    ,'slug'             => $request['slug']
                    ,'parent'           => $request['parent']
                    ,'num_sequence'     => $request['num_sequence']
                    ,'status'           => $request['status']);
    }

    
        
    private function _preparePropertiesDataForAddUpdate($request)
    {
        return array('volume'       => $request['volume']
                    ,'laminir'      => $request['laminir']
                    ,'temperature'  => $request['temperature']
                    ,'type_paper'   => $request['type_paper']
                    ,'amount_box'   => $request['amount_box']
                    ,'amount_rukav' => $request['amount_rukav']
                    ,'price_white'  => $request['price_white']
                    ,'price_color'  => $request['price_color']
                    ,'description'  => $request['description']);
        
    }
    
    
    
    private function _preparePropertiesImgDataForAddUpdate($request)
    {
        return array('img_white'    => isset($request['img_white']) && $request['img_white'] ? $request['img_white'] : $request['old_img_white']
                    ,'img_color'    => isset($request['img_color']) && $request['img_color'] ? $request['img_color'] : $request['old_img_color']);
    }
    
    
    
    public function ajax_catalog_upload_file()
    {
        $uploadingFile = $_FILES['catalog-img-'.$_REQUEST['img-type-name']];
        try{
            $this->_tryUploadFile($uploadingFile, './img/img_products/');
            $this->result['data'] = $uploadingFile['name'];
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
    
    
    
    public function ajax_catalog_delete_item()
    {
        try{
            $this->tryDeleteCatalogItem();
            $this->result['data'] = SUCCESS_MESS;
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
    
    
    
    public function tryDeleteCatalogItem()
    {
        $productsId     = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
        Common::assertTrue($productsId, 'Ошибка! Не установлен идентификатор продукта для удаления');
        
        $result = $this->index_model->dropCatalogProduct($productsId);
        Common::assertTrue($result, 'Ошибка! К сожалению, продукт не был удален. Попробуйте ще раз');
    }
    

        
    public function ajax_catalog_change_status_item()
    {
        try{
            $this->tryChangeStatusCatalogItem();
            $this->result['data'] = SUCCESS_MESS;
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
    
    
        
    public function tryChangeStatusCatalogItem()
    {
        $params['table']  = 'products';
   
        $params['id']     = isset($_REQUEST['catalogItemId']) && $_REQUEST['catalogItemId'] ? $_REQUEST['catalogItemId'] : null;
        Common::assertTrue($params['id'], 'Ошибка! Не установлен идентификатор продукта для изменения статуса');
        
        $data['status']     = isset($_REQUEST['itemStatus']) && $_REQUEST['itemStatus'] ? $_REQUEST['itemStatus'] : null;
        
        $result = $this->_updateInTable($data, $params);
        Common::assertTrue($result, 'Ошибка! К сожалению, статус не был изменен. Попробуйте ще раз');
    }
    
    
    
    public function ajax_catalog_change_position_item()
    {
        try{
            $this->tryChangePositionCatalogItem();
            $this->result['data'] = SUCCESS_MESS;
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
    
    
        
    public function tryChangePositionCatalogItem()
    {
        $params['table']  = 'products';
        $this->db->trans_start();
        
        $this->_updateCurrentCatalogPosition($params);
        $this->_updateBesideCatalogPosition($params);
        
        $this->db->trans_complete();
    }
    
    
    
    private function _updateCurrentCatalogPosition($params)
    {
        $params['id']     = isset($_REQUEST['currCatalogItemId']) && $_REQUEST['currCatalogItemId'] ? $_REQUEST['currCatalogItemId'] : null;
        Common::assertTrue($params['id'], 'Ошибка! Не установлен идентификатор продукта для изменения порядкового номера');
        
        $data['num_sequence']   = isset($_REQUEST['currNumSequence']) && $_REQUEST['currNumSequence'] ? $_REQUEST['currNumSequence'] : null;
 
        $result = $this->_updateInTable($data, $params);
        Common::assertTrue($result, 'Ошибка! К сожалению, статус не был изменен. Попробуйте ще раз');            
    }
    
    
    
    private function _updateBesideCatalogPosition($params)
    {
        $params['id']     = isset($_REQUEST['besideCatalogItemId']) && $_REQUEST['besideCatalogItemId'] ? $_REQUEST['besideCatalogItemId'] : null;
        Common::assertTrue($params['id'], 'Ошибка! Не установлен идентификатор ближайшего продукта для изменения порядкового номера');      
        
        $data['num_sequence']   = isset($_REQUEST['besideNumSequence']) && $_REQUEST['besideNumSequence'] ? $_REQUEST['besideNumSequence'] : null;
 
        $result = $this->_updateInTable($data, $params);
        Common::assertTrue($result, 'Ошибка! К сожалению, статус не был изменен. Попробуйте ще раз'); 
    }
        
/////////////////////////end catalog//////////////////////////////////////////////////////    
    
    private function _prepareUrl($urlArr)
    {
        $countUrl = count($urlArr) - 1;
        $url = '';

        for($i = 1; $i <= $countUrl; $i++){
            $url .= $urlArr[$i];
            if($i < ($countUrl)){
                $url .= '/';
            }
        }

        return $url;
    }



    private function _add($data, $params)
    {
        return $this->index_model->addInTable($data, $params['table']);
    }



    private function _update($data, $params)
    {
        if(!$this->index_model->updateInTable($params['id'], $data, $params['table'])){
            throw new Exception('Ошибка! К сожалению, информация не была обновлена. Попробуйте еще раз');
        }
    }

    
        
    private function _updateInTable($data, $params)
    {
        return $this->index_model->updateInTable($params['id'], $data, $params['table']);
    }

    

    private function _tryUploadFile($fileUploading, $uploadPath)
    {
        return Fileloader::loadFile($fileUploading['name'], $uploadPath, $fileUploading['tmp_name']);
    }

   
        
    private function _dropInTable($params)
    {
       return $this->index_model->delFromTable($params['id'], $params['table']);
    }
    

    
    public function drop($id)
    {
       $this->index_model->del($id);
       redirect('backend/news');
    }



//    private function _dropWithFile($dirTableName)
//    {
//        $error = null;
//        try{
//            $filename   = isset($_REQUEST['filename']) && $_REQUEST['filename'] ? $_REQUEST['filename'] : null;
//            $id         = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
//            Common::assertTrue($id, 'Id not set');
//            Common::assertTrue($filename, 'Filename not set');
//            
//            if(file_exists('./'.$dirTableName.'/'.$filename)){
//               unlink('./'.$dirTableName.'/'.$filename);
//            }
//           $isDeleted = $this->index_model->delFromTable($id, $dirTableName);
//           Common::assertTrue($isDeleted, 'Not deleted');
//
//        } catch(Exception $e){
//            $error = $e->getMessage();
//        }
//       print json_encode($error);
//    }

 
    
    private function _prepareMenu()
    {
       return $this->edit_menu_model->childs;
    }

    

    private function _prepareCatalog()
    {
       return $this->admin_menu_catalog_model->childs;
    }


   
    public function logout()
    {
        return $this->login_model->logOut();
    }

}