<?php

abstract class EIAbstract 
{
	
	const EXTENSION = '.wik';
	
	// wiki_articles
	protected $id;
	protected $id_contents;
	protected $title;
	protected $encoded_title;
	protected $hits;
	protected $id_cat;
	protected $is_cat;
	protected $defined_status;
	protected $undefined_status;
	protected $redirect;
	protected $auth;
	
	//wiki_cats
	protected $cat_id;
	protected $cat_id_parent;
	protected $cat_article_id;
	
	//wiki_contents
	
	protected $con_id_contents;
	protected $con_id_article;
	protected $menu;
	protected $content;
	protected $activ;
	protected $user_id;
	protected $user_ip;
	protected $timestamp;
	
	protected $fields = array(
		'id','id_contents','title','encoded_title','hits','id_cat','is_cat',
		'defined_status','undefined_status','redirect','auth',
		'cat_id','cat_id_parent','cat_article_id',
		'con_id_contents','con_id_article','menu','activ','user_id',
		'user_ip','timestamp','content'
	);
	
	// Others properties
	protected $real_path;
	protected $filename;
	
	// File
	protected $file;

	public function __construct($dir)
	{
		$this->real_path = $dir;
	}
	
	public function getId()
	{
		return $this->id;
	}

	public function getReal_path()
	{
		return $this->real_path;
	}
	
	public function getId_cat()
	{
		return $this->id_cat;
	}
	
	abstract public function export_to_files();
	
	public function hydrate_by_sql($row)
	{
		foreach ($this->fields as $field)
		{
			$this->{$field} = $row[$field];
		}
	}
	
	final protected function export_encoded()
	{
		$unparser = new EIUnparser($this->content);
		$unparser->unparse();
		$this->content = $unparser->get_content();
		
		foreach ($this->fields as $field)
		{
			$str = '<#' . $field . '#>' . $this->{$field} . '</#' . $field . '#>' . "\n";
			fputs($this->file, $str);
		}
	}
	
	protected function get_title_for_filename()
	{
		$forbid = array(">", "<",  ":", "*", "/", "|", "?", '"', '<', '>', "'");
		$filename = str_replace($forbid, " ", $this->title);
		$filename = preg_replace("# +#", " ", $filename);
		return trim($filename);
	}
}