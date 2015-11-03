<?php

abstract class WikiEIFileAbstract
{	
	// wiki_articles
	public $id;
	public $id_contents;
	public $title;
	public $encoded_title;
	public $hits;
	public $id_cat;
	public $is_cat;
	public $defined_status;
	public $undefined_status;
	public $redirect;
	public $auth;
	
	//wiki_cats
	public $cat_id;
	public $cat_id_parent;
	public $cat_article_id;
	
	//wiki_contents
	
	public $con_id_contents;
	public $con_id_article;
	public $menu;
	public $content;
	public $activ;
	public $user_id;
	public $user_ip;
	public $timestamp;
	
	public $fields = array(
		'id','id_contents','title','encoded_title','hits','id_cat','is_cat',
		'defined_status','undefined_status','redirect','auth',
		'cat_id','cat_id_parent','cat_article_id',
		'con_id_contents','con_id_article','menu','activ','user_id',
		'user_ip','timestamp','content'
	);
	
	// Others properties
	public $real_path;
	public $filename;
	
	public $type;
	
	// File
	public $file;
	
	abstract protected function before_to_export();

	public function __construct($dir)
	{
		$this->real_path = $dir;
	}
	
	public function hydrate_by_sql($row)
	{
		foreach ($this->fields as $field)
		{
			$this->{$field} = $row[$field];
		}
	}
	
	final public function export()
	{
		$this->prepare_title_for_filename();
		$this->unparse_content();
		
		$this->before_to_export();
		
		$writer = new WikiEIXMLWriter($this);
		
		foreach ($this->fields as $field)
		{
			$writer->add_field($field, $this->{$field});
		}
		$writer->save();
	}
	
	/**
	 * Preparation du titre du fichier
	 */
	protected function prepare_title_for_filename()
	{
		// Suppression des caractères non autorisés
		$forbid = array(">", "<",  ":", "*", "/", "|", "?", '"', '<', '>', "'");
		$this->filename = str_replace($forbid, " ", $this->title);
		// Suppression des espaces en trop
		$this->filename = preg_replace("# +#", " ", $this->filename);
		$this->filename = trim($this->filename);
	}
	
	/**
	 * Unparsage du contenu du fichier
	 */
	protected function unparse_content()
	{
		$unparser = new WikiEIUnparser($this->content);
		$unparser->unparse();
		$this->content = $unparser->get_content();
	}
}