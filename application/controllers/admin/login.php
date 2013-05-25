<?php
/**
 * @author Litkovskiy
 * @copyright 2012
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    public $data_arr   = array(), $result = array();

    public function __construct()
    {
        parent::__construct();
        $this->result            = array("success" => true, "message" => null, "data" => null);
    }

    

    public function index()
    {
        $this->data_arr  = array('title' => 'Color Ukraine - admin');
        $data = array( 'content' => $this->load->view('admin/login/show', $this->data_arr, true) );
        $this->load->view('layout_login', $data);
    }

    
    
    public function ajax_login()
    {
        $data['login']    = isset($_REQUEST['log'])  ? trim(strip_tags($_REQUEST['log']))  : '';
        $data['pass']     = isset($_REQUEST['pass']) ? trim(strip_tags($_REQUEST['pass'])) : '';

        try{
            Common::assertTrue($data['login'] != '' && $data['pass'] != '', 'Вы не ввели логин или пароль');
            $this->_setValidationRules();
            $this->_checkValid($data);
        } catch (Exception $e){
            $this->result['success'] = false;
            $this->result['message'] = $e->getMessage();
        }
    
        print json_encode($this->result);
        exit;
    }

    
    
    private function _setValidationRules()
    {
        $rules = array(
                array(
                    'field'	=> 'log',
                    'label'	=> 'login',
                    'rules'	=> 'required'),
                array(
                    'field'	=> 'pass',
                    'label'	=> 'password',
                    'rules'	=> 'required')
                );

        $this->form_validation->set_rules($rules);
    }
    
    
    
    private function _checkValid($data)
    {
        $isAuthorized = null;
        
        if ($this->form_validation->run() === false) {
            $this->index();
        } else {
            $isAuthorized = $this->login_model->checkLogPass($data['login'], $data['pass']);
            Common::assertTrue($isAuthorized, 'Вы ввели неверный логин или пароль!');
        }
    }
}