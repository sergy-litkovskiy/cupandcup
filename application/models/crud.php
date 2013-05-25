<?php

/**
 * @author Litkovsky
 * @copyright 2012
 * model for all objects of site
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Crud extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }


    
    public function addInTable($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
    

    public function updateInTable($id, $data, $table)
    {
        $this->db->where('id', $id);
        if(!$this->db->update($table, $data))
        {
            return false;
        }
        return true;
    }

    

    public function delFromTable($id, $table)
    {
        $this->db->where('id', $id);
        if(!$this->db->delete($table))
        {
            return false;
        }
        return true;
    }

    
    
    public function getFromTableById($id, $table)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($table);

        return $query->result_array();
    }
	
    

    public function getFromTableByParams($params, $table)
    {
        $this->db->where($params);
        $query = $this->db->get($table);
        
        return $query->result_array();
    }
    
    

    public function getListFromTable($table)
    {
        $query = $this->db->get($table);
        return $query->result_array();
    }
	

    
    public function getArrWhere($table, $params, $limit, $offset , $order_by = false)
    {
        $order_by ? $this->db->order_by($order_by) : false;
        $query = $this->db->get_where($table, $params, $limit, $offset);

        return $query->result_array();
    }
}