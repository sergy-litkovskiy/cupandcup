<?php
/**
 * @author Litkovsky
 * @copyright 2012
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_menu_catalog_model extends Crud
{
    public  $menu_id, $products_parent, $products_title, $products_slug, $products_status
            , $products_seo_title, $products_seo_description, $products_seo_keywords, $products_num_sequence
            , $id, $products_id, $volume, $laminir, $temperature, $type_paper
            , $amount_box, $amount_rukav, $price_white, $price_color
            , $description, $img_white, $img_color;
    public  $childs = array();
    
    function __construct($id = 0)
    {
        parent::__construct();
        $query_parent         = $this->db->query("SELECT
                                                        products.id as menu_id
                                                        , products.parent as products_parent
                                                        , products.title as products_title
                                                        , products.slug as products_slug
                                                        , products.status as products_status
                                                        , products.seo_title as products_seo_title
                                                        , products.seo_keywords as products_seo_keywords
                                                        , products.seo_description as products_seo_description
                                                        , products.num_sequence as products_num_sequence
                                                        , properties.*
                                                    FROM
                                                        products
                                                    LEFT JOIN
                                                        properties
                                                    ON
                                                        products.id = properties.products_id
                                                    WHERE
                                                        products.id = ".$id."
                                                    ORDER by
                                                        products.num_sequence");
        $arr_menu_parent_item = $query_parent->result_array();
        
        $this->menu_id          = empty($arr_menu_parent_item)                       ? 0 : $arr_menu_parent_item[0]['menu_id'];
        $this->products_parent  = empty($arr_menu_parent_item[0]['products_parent']) ? 0 : $arr_menu_parent_item[0]['products_parent'];
        $this->products_title   = empty($arr_menu_parent_item[0]['products_title'])  ? 0 : $arr_menu_parent_item[0]['products_title'];
        $this->products_slug    = empty($arr_menu_parent_item[0]['products_slug'])   ? 0 : $arr_menu_parent_item[0]['products_slug'];
        $this->products_status  = empty($arr_menu_parent_item[0]['products_status']) ? 0 : $arr_menu_parent_item[0]['products_status'];

        $this->products_seo_title       = empty($arr_menu_parent_item[0]['products_seo_title'])         ? 0 : $arr_menu_parent_item[0]['products_seo_title'];
        $this->products_seo_description = empty($arr_menu_parent_item[0]['products_seo_description'])   ? 0 : $arr_menu_parent_item[0]['products_seo_description'];
        $this->products_seo_keywords    = empty($arr_menu_parent_item[0]['products_seo_keywords'])      ? 0 : $arr_menu_parent_item[0]['products_seo_keywords'];
        $this->products_num_sequence    = empty($arr_menu_parent_item[0]['products_num_sequence'])      ? 0 : $arr_menu_parent_item[0]['products_num_sequence'];
        
        $this->id           = empty($arr_menu_parent_item[0]['id'])             ? 0 : $arr_menu_parent_item[0]['id'];
        $this->products_id  = empty($arr_menu_parent_item[0]['products_id'])    ? 0 : $arr_menu_parent_item[0]['products_id'];
        $this->volume       = empty($arr_menu_parent_item[0]['volume'])         ? 0 : $arr_menu_parent_item[0]['volume'];
        $this->laminir      = empty($arr_menu_parent_item[0]['laminir'])        ? 0 : $arr_menu_parent_item[0]['laminir'];
        $this->temperature  = empty($arr_menu_parent_item[0]['temperature'])    ? 0 : $arr_menu_parent_item[0]['temperature'];
        $this->type_paper   = empty($arr_menu_parent_item[0]['type_paper'])     ? 0 : $arr_menu_parent_item[0]['type_paper'];
        $this->amount_box   = empty($arr_menu_parent_item[0]['amount_box'])     ? 0 : $arr_menu_parent_item[0]['amount_box'];
        $this->amount_rukav = empty($arr_menu_parent_item[0]['amount_rukav'])   ? 0 : $arr_menu_parent_item[0]['amount_rukav'];
        $this->price_white  = empty($arr_menu_parent_item[0]['price_white'])    ? 0 : $arr_menu_parent_item[0]['price_white'];
        $this->price_color  = empty($arr_menu_parent_item[0]['price_color'])    ? 0 : $arr_menu_parent_item[0]['price_color'];
        $this->description  = empty($arr_menu_parent_item[0]['description'])    ? 0 : $arr_menu_parent_item[0]['description'];
        $this->img_white    = empty($arr_menu_parent_item[0]['img_white'])      ? 0 : $arr_menu_parent_item[0]['img_white'];
        $this->img_color    = empty($arr_menu_parent_item[0]['img_color'])      ? 0 : $arr_menu_parent_item[0]['img_color'];
        
        $query_childs  = $this->db->query("SELECT 
                                                products.id as menu_id
                                                , products.parent as products_parent
                                                , products.title as products_title
                                                , products.slug as products_slug
                                                , products.status as products_status
                                                , products.seo_title as products_seo_title
                                                , products.seo_keywords as products_seo_keywords
                                                , products.seo_description as products_seo_description
                                                , products.num_sequence as products_num_sequence
                                                , properties.*
                                            FROM
                                                products
                                            LEFT JOIN
                                                properties
                                            ON
                                                products.id = properties.products_id
                                            WHERE
                                                products.parent = ".$this->menu_id ."
                                            ORDER by
                                                products.num_sequence");
        $arr_menu_item = $query_childs->result_array();
        
        foreach($arr_menu_item as $val){
           $child = new Admin_menu_catalog_model($val['menu_id']);
           $this->childs[] = $child;
        }
    }       
}