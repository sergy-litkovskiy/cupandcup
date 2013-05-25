<?php
/**
 * @author Litkovsky
 * @copyright 2012
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_catalog_model extends Crud
{
    public  $id, $parent, $title, $slug, $meta_title, $meta_description, $meta_keywords, $price_color;
    public  $childs = array();
    
    function __construct($id = 0)
    {
        parent::__construct();
        $query_parent         = $this->db->query("SELECT
                                                        products.*,
                                                        properties.price_color as price_color
                                                    FROM
                                                        products
                                                    LEFT JOIN    
                                                        properties
                                                    ON
                                                        properties.products_id = products.id
                                                    WHERE
                                                        products.id = ".$id."
                                                    AND
                                                        products.status = 1
                                                    ORDER by
                                                        products.num_sequence");
        $arr_menu_parent_item = $query_parent->result_array();
        
        $this->id      = empty($arr_menu_parent_item)              ? 0 : $arr_menu_parent_item[0]['id'];
        $this->parent  = empty($arr_menu_parent_item[0]['parent']) ? 0 : $arr_menu_parent_item[0]['parent'];
        $this->title   = empty($arr_menu_parent_item[0]['title'])  ? 0 : $arr_menu_parent_item[0]['title'];
        $this->slug    = empty($arr_menu_parent_item[0]['slug'])   ? 0 : $arr_menu_parent_item[0]['slug'];
        
        $this->price_color      = empty($arr_menu_parent_item[0]['price_color'])       ? 0 : $arr_menu_parent_item[0]['price_color'];
        $this->meta_title       = empty($arr_menu_parent_item[0]['seo_title'])         ? 0 : $arr_menu_parent_item[0]['seo_title'];
        $this->meta_description = empty($arr_menu_parent_item[0]['seo_description'])   ? 0 : $arr_menu_parent_item[0]['seo_description'];
        $this->meta_keywords    = empty($arr_menu_parent_item[0]['seo_keywords'])      ? 0 : $arr_menu_parent_item[0]['seo_keywords'];
        $query_childs  = $this->db->query("SELECT 
                                                products.*,
                                                properties.price_color as price_color
                                            FROM
                                                products
                                            LEFT JOIN    
                                                properties
                                            ON
                                                properties.products_id = products.id                                                  
                                            WHERE
                                                products.parent = ".$this->id."
                                            AND
                                                products.status = 1
                                            ORDER by
                                                products.num_sequence");
        $arr_menu_item = $query_childs->result_array();
        
        foreach($arr_menu_item as $val){
           $child = new Menu_catalog_model($val['id']);
           $this->childs[] = $child;
        }
    }       
}