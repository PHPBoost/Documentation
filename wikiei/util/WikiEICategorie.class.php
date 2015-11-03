<?php

class WikiEICategorie extends WikiEIFileAbstract 
{
	public $type = 'cat';
	
	/**
	 * Préparation du chemin à créer
	 */
	protected function before_to_export()
	{
		$this->real_path .= '/' . $this->title;
		
		mkdir($this->real_path);
	}
	
	/**
	 * Le nom du fichier regroupant les infos de la catégorie est indépendant de son nom
	 */
	protected function prepare_title_for_filename()
	{
		$this->filename = '_cat_infos';
	}
	
	
}