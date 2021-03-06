<?php
/**
 * @author Litkovsky
 * @copyright 2010
 * model for object MENU_ADMIN - recursive getting menu items
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_menu_model extends Crud
{
    public  $id, $title, $slug, $description, $status, $seo_description, $seo_keywords, $seo_title, $numSeq;
    public  $childs = array();
    var $idkey = 'id';
    var $table = 'menu';

    function __construct($id = 0)
    {
        parent::__construct();
        $query_parent         = $this->db->query("SELECT
                                                        menu.*
                                                    FROM
                                                        menu
                                                    WHERE
                                                        menu.id = ".$id."
                                                    ORDER by
                                                        menu.num_sequence");
        $arr_menu_parent_item = $query_parent->result_array();

        $this->id      = empty($arr_menu_parent_item)              ? 0 : $arr_menu_parent_item[0]['id'];
        $this->title   = empty($arr_menu_parent_item[0]['title'])  ? 0 : $arr_menu_parent_item[0]['title'];
        $this->slug    = empty($arr_menu_parent_item[0]['slug'])   ? 0 : $arr_menu_parent_item[0]['slug'];
        $this->description    = empty($arr_menu_parent_item[0]['description'])   ? 0 : $arr_menu_parent_item[0]['description'];
        $this->status  = empty($arr_menu_parent_item[0]['status']) ? 0 : $arr_menu_parent_item[0]['status'];
        $this->numSeq  = empty($arr_menu_parent_item[0]['num_sequence']) ? 0 : $arr_menu_parent_item[0]['num_sequence'];

        $this->seo_description = empty($arr_menu_parent_item[0]['seo_description'])   ? 0 : $arr_menu_parent_item[0]['seo_description'];
        $this->seo_keywords    = empty($arr_menu_parent_item[0]['seo_keywords'])      ? 0 : $arr_menu_parent_item[0]['seo_keywords'];
        $this->seo_title       = empty($arr_menu_parent_item[0]['seo_title'])      ? 0 : $arr_menu_parent_item[0]['seo_title'];
        $query_childs  = $this->db->query("SELECT
                                                menu.*
                                            FROM
                                                menu
                                            WHERE
                                                menu.parent = ".$this->id."
                                            ORDER by
                                                menu.num_sequence");
        $arr_menu_item = $query_childs->result_array();

        foreach($arr_menu_item as $val){
           $child = new Edit_menu_model($val['id']);
           $this->childs[] = $child;
        }
    }       

    public function getMenuItems($parentId = null)
    {
        $parent = $parentId ? $parentId : '0';
        $query_parent = $this->db->query("SELECT
                                                *
                                            FROM
                                                menu
                                            WHERE
                                                parent = '".$parent."'");
        return $query_parent->result_array();
    }

    public function getContentMenuById($id)
    {
        $query_parent = $this->db->query("SELECT * FROM menu WHERE id = '".$id."'");
        return $query_parent->result_array();
    }
}
?>
