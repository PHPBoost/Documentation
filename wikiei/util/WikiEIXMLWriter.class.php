<?php

class WikiEIXMLWriter
{
	private $file;
	
	private $content;
	
	const PREFIX = 'wiki_';
	
	public function __construct(\WikiEIFileAbstract $file)
	{
		$this->file = $file;
		
		$this->init_content();
	}
	
	public function add_field($name, $value)
	{
		$this->content .= '  <' . self::PREFIX . $name . '>' . $value . '</' . self::PREFIX . $name . '>' . "\n";
	}
	
	public function save()
	{
		$this->content .= '</' . self::PREFIX . $this->file->type . '>';
		
		$file = fopen($this->file->real_path . '/' . $this->file->filename . '.xml', 'a');
		fputs($file, $this->content);
		fclose($file);
	}
	
	private function init_content()
	{
		$this->content = '<?xml version="1.0" encoding="iso-8859-1"?>'."\n";
		$this->content .= '<' . self::PREFIX . $this->file->type . '>' . "\n";
	}
	
	
}

