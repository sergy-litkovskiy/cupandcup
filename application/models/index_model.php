<?php
/**
 * @author Litkovsky
 * @copyright 2012
 * model for index page
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_model extends Crud
{
    protected $params, $key, $tableName ;

    public function __construct()
    {
        parent::__construct();
        $this->params = array('limit' => null, 'status' => null);
        $this->key;
        $this->tableName;
    }

    
    
    public function getCategoriesListByParentSlug($parentSlug)
    {
        $sql =  "SELECT
                      p1.id as products_id
                    , p1.title as products_title
                    , p1.slug as products_slug
                    , (SELECT p2.title FROM products as p2 WHERE p2.slug = '".$parentSlug."') as parent_title
                FROM
                    products as p1
                WHERE
                    p1.parent = (SELECT p2.id FROM products as p2 WHERE p2.slug = '".$parentSlug."')
                    AND
                    p1.status = ".STATUS_ON."
                ORDER by
                    p1.num_sequence";
                
        $sql_query = $this->db->query($sql);
        return $sql_query->result_array();
    }   
    
    
    
    public function getProductByProductSlug($productSlug)
    {
        $sql =  "SELECT
                      products.id as products_id
                    , products.parent as products_parent
                    , products.title as products_title
                    , products.slug as products_slug
                    , products.seo_title as products_seo_title
                    , products.seo_keywords as products_seo_keywords
                    , products.seo_description as products_seo_description
                    , properties.*
                FROM
                    products
                INNER JOIN
                    properties
                ON
                    products.id = properties.products_id
                WHERE
                    products.slug = '".$productSlug."'
                    AND
                    products.status = ".STATUS_ON."";
                
        $sql_query = $this->db->query($sql);
        return $sql_query->result_array();
    }



    public function getContent($slug)
    {
        return $this->getFromTableByParams(array('slug' => $slug), 'menu');
    }


    
    public function insertOrderMaster($data)
    {
        return $this->addInTable($data, 'order_master');
    }

    

    public function insertOrderProducts($orderMasterId, $productArr)
    {
        $dataProductArr = array();
        foreach($productArr as $product){
            $dataProductArr['parent_name']      = $product['parent_name'];
            $dataProductArr['product_name']     = $product['product_name'];
            $dataProductArr['property_type']    = $product['property_type'];
            $dataProductArr['amount']           = $product['amount'];
            $dataProductArr['order_master_id']  = $orderMasterId;
            $this->addInTable($dataProductArr, 'order_products');
        }
    }
    
    
    
    public function sendOrderDetailEmail($data)
    {
        $productList = $this->_prepareProductList($data['products_arr']);
        $body = "<tr><td colspan='4'><b><p style='text-align: center'>ЗАКАЗ от ".$data['created_at']."</p></b></td></tr>
                    <tr>
                    <td colspan='2' style='border-right:dotted 1px #999'>
                        <p><b>Плательщик:</b> ".$data['name_payer']."</p>
                        <p><b>Получатель:</b> ".$data['name_recipient']."</p>
                        <p><b>Email:</b> ".$data['email']."</p>
                        <p><b>Телефон:</b> ".$data['phone']."</p>
                    </td>
                    <td colspan='2'>
                        <p><b>Город:</b> ".$data['city']."</p>
                        <p><b>Комментарий:</b> ".$data['comment']."</p>
                    </td>
                </tr>
                <tr>
                    <td style='background:#C2CBE0'><b>Категория:</b></td>
                    <td style='background:#C2CBE0'><b>Продукция:</b></td>
                    <td style='background:#C2CBE0'><b>Описание:</b></td>
                    <td style='background:#C2CBE0'><b>Кол-во:</b></td>
                </tr>
                ".$productList."";
        $message = $this->_getEmailTamplate($body);

        return $this->_sendAdminEmailMessage($message);
    }
    
    
    
    private function _prepareProductList($productsArr)
    {
        $products = "";
        foreach($productsArr as $product){
            $products .= "<tr>
                            <td style='border-right:dotted 1px #999; border-bottom:dotted 1px #999'><p>".$product['parent_name']."</p></td>
                            <td style='border-right:dotted 1px #999; border-bottom:dotted 1px #999'><p>".$product['product_name']."</p></td>
                            <td style='border-right:dotted 1px #999; border-bottom:dotted 1px #999'><p>".$product['property_type']."</p></td>
                            <td style='border-bottom:dotted 1px #999'>".$product['amount']."</td>
                         </tr>";
        }
      
        return $products;
    }
    
    

    public function sendAdminErrorEmailMessage($errorMess)
    {
        $message = "Type of message: 'Error message'<br/>\r\n 
                    Date: ".date('Y-m-d')." / Time ".date('H:i:s')."<br/>\r\n
                    Message error: ".$errorMess.")<br/>\r\n";

        return $this->_sendAdminEmailMessage($message);
    }


    
    public function sendEmailMessage($data)
    {
        $message = "Type of message: 'Message from contact form'<br/>\r\n 
                    Date: ".date('Y-m-d')." / Time ".date('H:i:s')."<br/>\r\n
                    Message from: ".$data['name']." (email of author :".$data['email'].").<br/>\r\n
                    Message: ".@$data['text'].".\r\n";

        return $this->_sendAdminEmailMessage($message);
    }

    
        
    public function sendContactFormEmail($data)
    {
        $message = "Тип сообщения: 'Заказ консультации относительно старта своего бизнеса'<br/>\r\n 
                    Дата: ".$data['created_at']."<br/>\r\n
                    Имя заказчика: ".$data['name']."<br/>\r\n
                    Email заказчика: ".$data['email']."<br/>\r\n
                    город заказчика: ".$data['city'].".";

        return $this->_sendAdminEmailMessage($message);
    }
    
    

    private function _sendAdminEmailMessage($message)
    {
        $headers    = $this->_getMailHeader();
        $email      = SUPERADMIN_EMAIL.",andrey.kononchuk.gmail.com";
        $subject    = "Message from Cupandcup site";
        $isMailSent = mail($email, $subject, $message, $headers);

        return $isMailSent;
    }



    private function _getMailHeader()
    {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: sale@cupandcup.com \r\n";
        
        return $headers;
        
    }
    
    
    
    private function _getEmailTamplate($body)
    {
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
                            <title>Cupancup</title>
                        </head>
                        <body>
                            <table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
                                '.$body.'
                            </table>
                        </body>
                            <style type="text/css">
                                body {
                                    margin: 0;
                                    background: #fff;
                                    font-size: 14px;
                                }
                                p { margin-bottom: 10px; font-size: 10pt; color:#4E4E4E}
                                a {color:red; font-size:10pt}
                                a:hover { text-decoration: none; }
                                td {height:250; vertical-align: top; padding:10px}
                                table {border: dotted 1px #999;}
                            </style>
                        </html>';
    }
	
    
    
    public function delFromTableByParams($assignsArr, $oldAssignMenuId)
    {
        $this ->db->where($assignsArr['assignFieldName'], $assignsArr['id']);
        $this ->db->where('menu_id', $oldAssignMenuId);
        if(!$this->db->delete($assignsArr['table']))
        {
            return false;
        }
        return true;
    }

    
        
    public function updateCatalog($data)
    {
        $this->db->trans_start();
        
        $this->db->where('id', $data['products']['id']);
        $productsResult     = $this->db->update('products', $data['products']);
        
        $this->db->where('id', $data['properties']['id']);
        $propertiesResult   = $this->db->update('properties', $data['properties']);
        
        $this->db->trans_complete();
        Common::assertTrue($productsResult && $propertiesResult, 'Ошибка! К сожалению, изменения не были внесены. Попробуйте ще раз');
        return true;
    }

    
    
    public function addCatalog($data)
    {
        $this->db->trans_start();
        
        $productsId     = $this->addInTable($data['products'], 'products');
        $data['properties']['products_id'] = $productsId;
        $propertiesId   = $this->addInTable($data['properties'], 'properties');
        
        $this->db->trans_complete();
        Common::assertTrue($productsId && $propertiesId, 'Ошибка! К сожалению, изменения не были внесены. Попробуйте ще раз');
        return true;
    }
    
    
        
    public function dropCatalogProduct($productsId)
    {
        $this->db->trans_start();
        
        $productsResult     = $this->delFromTable($productsId, 'products');
        $propertiesResult   = $this->db->delete('properties', array('products_id' => $productsId));
        
        $subProductsArr = $this->getFromTableByParams(array('parent' => $productsId), 'products');
        if(count($subProductsArr)){
            $this->db->delete('products', array('parent' => $productsId));
            foreach($subProductsArr as $subProduct){
                $this->db->delete('properties', array('products_id' => $subProduct['id']));                
            }
        }
        $this->db->trans_complete();
        Common::assertTrue($productsResult && $propertiesResult, 'Ошибка! К сожалению, изменения не были внесены. Попробуйте ще раз');
        return true;
    }
}