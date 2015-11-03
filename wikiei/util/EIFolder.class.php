<?php

class EIFolder extends EIAbstract {
	
	public function export_to_files()
	{
		$this->real_path .= '/' . $this->get_title_for_filename();
		mkdir($this->real_path);
		
		$this->file = fopen($this->real_path . '/_cat_info' . self::EXTENSION, 'a');
		$this->export_encoded();


		fclose($this->file);
	}
	
	
}