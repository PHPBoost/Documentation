<?php

class EIFile extends EIAbstract {
	
	protected $title_filename;
	
	public function export_to_files()
	{
		$this->file = fopen($this->real_path . '/' . $this->get_title_for_filename() . self::EXTENSION, 'a');
		$this->export_encoded();
		

		fclose($this->file);
	}
	
	
	
	
	
}