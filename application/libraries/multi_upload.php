<?php

/**
 * Multi Upload
 *
 * @author		Dida Nurwanda
 * @email		dida_n@ymail.com
 */
 
require_once SYSDIR.'/libraries/Upload.php';

class multi_upload extends CI_Upload
{
	public function __construct($props = array())
	{
		parent::__construct($props);
	}
	
	public function do_upload($data=array())
	{
		if (!isset($data))
		{
			$this->set_error('upload_no_file_selected');
			return FALSE;
		}
		if (!$this->validate_upload_path())
			return FALSE;
		if (!is_uploaded_file($data['tmp_name']))
		{
			$error = ( ! isset($data['error'])) ? 4 : $data['error'];
			switch($error)
			{
				case 1:	
					$this->set_error('upload_file_exceeds_limit');
					break;
				case 2:
					$this->set_error('upload_file_exceeds_form_limit');
					break;
				case 3:
					$this->set_error('upload_file_partial');
					break;
				case 4:
					$this->set_error('upload_no_file_selected');
					break;
				case 6:
					$this->set_error('upload_no_temp_directory');
					break;
				case 7: 
					$this->set_error('upload_unable_to_write_file');
					break;
				case 8: 
					$this->set_error('upload_stopped_by_extension');
					break;
				default :   $this->set_error('upload_no_file_selected');
					break;
			}
			return FALSE;
		}
		$this->file_temp = $data['tmp_name'];
		$this->file_size = $data['size'];
		$this->_file_mime_type($data);
		$this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $this->file_type);
		$this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
		$this->file_name = $this->_prep_filename($data['name']);
		$this->file_ext	 = $this->get_extension($this->file_name);
		$this->client_name = $this->file_name;
		if (!$this->is_allowed_filetype())
		{
			$this->set_error('upload_invalid_filetype');
			return FALSE;
		}
		if ($this->_file_name_override != '')
		{
			$this->file_name = $this->_prep_filename($this->_file_name_override);
			if (strpos($this->_file_name_override, '.') === FALSE)
				$this->file_name .= $this->file_ext;
			else
				$this->file_ext	 = $this->get_extension($this->_file_name_override);
			if (!$this->is_allowed_filetype(TRUE))
			{
				$this->set_error('upload_invalid_filetype');
				return FALSE;
			}
		}
		if ($this->file_size > 0)
			$this->file_size = round($this->file_size/1024, 2);
		if (!$this->is_allowed_filesize())
		{
			$this->set_error('upload_invalid_filesize');
			return FALSE;
		}
		if (!$this->is_allowed_dimensions())
		{
			$this->set_error('upload_invalid_dimensions');
			return FALSE;
		}
		$this->file_name = $this->clean_file_name($this->file_name);
		if ($this->max_filename > 0)
			$this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
		if ($this->remove_spaces == TRUE)
			$this->file_name = preg_replace("/\s+/", "_", $this->file_name);
		$this->orig_name = $this->file_name;
		if ($this->overwrite == FALSE)
		{
			$this->file_name = $this->set_filename($this->upload_path, $this->file_name);
			if ($this->file_name === FALSE)
				return FALSE;
		}
		if ($this->xss_clean)
		{
			if ($this->do_xss_clean() === FALSE)
			{
				$this->set_error('upload_unable_to_write_file');
				return FALSE;
			}
		}
		if ( ! @copy($this->file_temp, $this->upload_path.$this->file_name))
		{
			if ( ! @move_uploaded_file($this->file_temp, $this->upload_path.$this->file_name))
			{
				$this->set_error('upload_destination_error');
				return FALSE;
			}
		}
		$this->set_image_properties($this->upload_path.$this->file_name);
		return TRUE;
	}
}