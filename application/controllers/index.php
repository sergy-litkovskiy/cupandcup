<?php
/**
 * @author Litkovskiy
 * @copyright 2012
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller 
{
    public $arrMenu             = array();
    public $arrMenuCatalog      = array();
    public $defaultDescription  = '';
    public $defaultKeywords     = '';
    public $contactFormArr, $result;


    public function __construct()
    {
        parent::__construct();
        $this->arrMenu           = $this->_prepareMenu();
        $this->arrMenuCatalog    = $this->_prepareMenuCatalog();
        $this->contactFormArr    = array('contact_form' => array('name' => null, 'email' => null, 'text' => null));
        $this->result            = array("success" => true, "message" => null, "data" => null);
        $this->urlArr            = explode('/',$_SERVER['REQUEST_URI']);
        $i = 0;
        foreach($this->urlArr as $value){
            if($value == ''){
                $i++;
            }
        }

        $this->isEmptyUrlArr = count($this->urlArr) == $i ? true : false;       
    }


    
    public function index()
    {
        $this->catalog('cups');
    }

    
    
    public function catalog($parentSlug, $productSlug = null)
    {
        $categories             = $this->index_model->getCategoriesListByParentSlug($parentSlug);

        if(!$productSlug){
            $productSlug    = $categories[0]['products_slug'];
            $this->urlArr   = array_merge($this->urlArr, array($categories[0]['products_slug']));
        }
        
        $productsArr    = $this->index_model->getProductByProductSlug($productSlug);
        $categories     = $this->_appendParentSlugToCategories($categories, $parentSlug);
       
        $productsArr[0]['product_description'] = $this->_prepareProductDescription($productsArr[0]);
        $urlSegments        = $this->isEmptyUrlArr ? array($parentSlug, $categories[0]['products_slug']) : $this->urlArr;
        $title              = count($productsArr) > 0 ? $categories[0]['parent_title']." - ".$productsArr[0]['products_title'] : null;
        $this->data_menu    = array( 'menu'         => $this->arrMenu
                                    , 'menu_catalog' => $this->arrMenuCatalog
                                    , 'url_segments' => $urlSegments);    

        $this->data_arr      = array(
                'title'         	=> SITE_TITLE.' - '.$title
                ,'meta_keywords'	=> $productsArr[0]['products_seo_keywords']      ? $productsArr[0]['products_seo_keywords']       : $this->defaultDescription
                ,'meta_description'	=> $productsArr[0]['products_seo_description']   ? $productsArr[0]['products_seo_description']    : $this->defaultKeywords
                ,'product'       	=> $productsArr[0]
                ,'categories'           => $this->load->view('blocks/product_nav_panel', array('categories' => $categories, 'url_segments' => $urlSegments), true)
                ,'order_container'      => $this->load->view('blocks/order_container', array('catalog_items' => $this->arrMenuCatalog), true)
        );

        $data = array(
                    'menu'          => $this->load->view(MENU, $this->data_menu, true),
                    'content'       => $this->load->view('index/products', $this->data_arr, true));

        $this->load->view('layout', $data);
    }
    
    
    
    private function _appendParentSlugToCategories($categories, $parentSlug)
    {
        foreach($categories as $key => $category){
            $categories[$key]['parent_slug'] = $parentSlug;
        }
        
        return $categories;
    }
    
    
    
    private function _prepareProductDescription($product)
    {
        $description = array();
        if($product['volume'] != 0){
            $description['Полный объём:']   = $product['volume'];
        }
        if($product['laminir'] !== ''){
            $description['Ламинирование:']  = $product['laminir'];
        }
        if($product['temperature'] !== ''){
            $description['Маx. температура:']   = $product['temperature'];
        }
        if($product['type_paper'] !== ''){
            $description['Плотность бумаги:']   = $product['type_paper'];
        }
        if($product['description'] !== ''){
            $description['Описание:']   = $product['description'];
        }
        
        return $description;
    }
    
    
        
    public function show($slug)
    {
        $content    = $this->_getContentFromMenuArrBySlug($slug);

        $title              = $content ? ' - '.$content->title : null;
        $this->data_menu    = array('menu' => $this->arrMenu, 'url_segments' => $this->urlArr, 'menu_catalog' => $this->arrMenuCatalog);    
        $this->data_arr     = array(
                'title'         	=> SITE_TITLE.$title
                ,'meta_keywords'	=> $content->meta_keywords      ? $content->meta_keywords       : $this->defaultDescription
                ,'meta_description'	=> $content->meta_description   ? $content->meta_description    : $this->defaultKeywords
                ,'content'       	=> $content
                ,'contact_map'       	=> $content->slug == 'contacts' ? $this->load->view('blocks/contact_map', '', true) : null
                ,'contact_form'       	=> $content->slug == 'business' ? $this->load->view('blocks/contact_form', '', true) : null
        );

        $data = array(
                    'menu'          => $this->load->view(MENU, $this->data_menu, true),
                    'content'       => $this->load->view('index/show', $this->data_arr, true));

        $this->load->view('layout', $data);
    }
    
    
        
    private function _getContentFromMenuArrBySlug($slug)
    {
        $content = null;
        foreach($this->arrMenu as $menuItem){
            if($menuItem->slug == $slug){
                $content = $menuItem;
            }
        }
        return $content;
    }

    
    
    public function ajax_place_order()
    {
        try{
            $this->_place_order_process($_REQUEST['order_item_arr']);
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }


        
    public function gallery()
    {
        $content    = $this->index_model->getFromTableByParams(array('status' => STATUS_ON), 'gallery');

        $title              = ' - Галерея';
        $this->data_menu    = array('menu' => $this->arrMenu, 'url_segments' => $this->urlArr, 'menu_catalog' => $this->arrMenuCatalog);    
        $this->data_arr     = array(
                'title'         	=> SITE_TITLE.$title
                ,'meta_keywords'	=> $this->defaultDescription
                ,'meta_description'	=> $this->defaultKeywords
                ,'content'       	=> $content
        );

        $data = array(
                    'menu'          => $this->load->view(MENU, $this->data_menu, true),
                    'content'       => $this->load->view('index/gallery', $this->data_arr, true));

        $this->load->view('layout', $data);
    }
    
    
    
    private function _place_order_process($request)
    {
        Common::assertTrue(count($request['products_arr']) > 0, 'Внимание! Для оформления заказа необходимо указать тип продукции и его количество');
        
        $data = $this->_prepareData($request);
        $orderMasterId = $this->index_model->insertOrderMaster($data);
        Common::assertTrue($orderMasterId, "К сожалению, заказ не был оформлен.<br/>Пожалуйста, попробуйте еще раз");
      
        $this->index_model->insertOrderProducts($orderMasterId, $request['products_arr']);
        
        $data['products_arr'] = $request['products_arr'];
        $this->index_model->sendOrderDetailEmail($data);
    }
    
    

    private function _prepareData($request)
    {
        $data = array();
        $data['name_payer']         = trim(strip_tags($request['name_payer']));
        $data['name_recipient']     = trim(strip_tags($request['name_recipient']));
        $data['email']              = trim(strip_tags($request['email']));
        $data['phone']              = trim(strip_tags($request['phone']));
        $data['city']               = trim(strip_tags($request['city']));
//        $data['delivery_method']    = $request['delivery_method'] == 0 ? 'Самовывоз' : 'Доставка производителя';
        $data['comment']            = trim(strip_tags($request['comment']));
        $data['created_at']         = date('Y-m-d H:i:s');
        return $data;
    }

   
        
    public function ajax_send_contact_mail()
    {
        try{
            $this->_send_mail_process($_REQUEST['form_data']);
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }

    
        private function _send_mail_process($request)
    {
        Common::assertTrue(count($request) > 0, 'Внимание! Для оформления заказа необходимо заполнить все поля');
        $data = $this->_prepareContactFormData($request);
        $this->index_model->sendContactFormEmail($data);
    }
    
    

    private function _prepareContactFormData($request)
    {
        $data = array();
        $data['name']         = trim(strip_tags($request['name']));
        $data['email']        = trim(strip_tags($request['email']));
        $data['phone']        = trim(strip_tags($request['phone']));
        $data['city']         = trim(strip_tags($request['city']));
        $data['created_at']   = date('Y-m-d H:i:s');
        return $data;
    }
    
    
    
    private function _prepareMenu()
    {
       return $this->menu_model->childs;
    }
    
        
    private function _prepareMenuCatalog()
    {
       return $this->menu_catalog_model->childs;
    }
}