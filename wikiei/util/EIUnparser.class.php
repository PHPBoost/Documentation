<?php

class EIUnparser
{
	protected $content;
	
	protected $unparser;
	
	public function __construct($content)
	{
		$this->content = $content;
		$content_manager = AppContext::get_content_formatting_service()->get_default_factory();
		$this->unparser = $content_manager->get_unparser();
	}

	public function unparse()
	{
		$this->build_original_paragraph();
		
		//Unparse de la balise link
		$this->content = preg_replace('`<a href="/wiki/([a-z0-9+#-_]+)">(.*)</a>`sU', "[link=$1]$2[/link]", $this->content);

		//On force le langage de formatage à BBCode
		
		$this->unparser->set_content($this->content);
		$this->unparser->parse();

		$this->content = $this->unparser->get_content();
	}
	
	public function get_content()
	{
		return $this->content;
	}

	protected function build_original_paragraph()
	{
		$string_regex = '-';
		for ($i = 1; $i <= 5; $i++)
		{
			$string_regex .= '-';
			$this->content = preg_replace('`[\r\n]+<(?:div|h[1-5]) class="wiki_paragraph' .  $i . '" id=".+">(.+)</(?:div|h[1-5])><br />[\r\n]+`sU', "\n" . $string_regex . ' $1 '. $string_regex, "\n" . $this->content . "\n");
		}
		$this->content = trim($this->content);
	}
	
	
}

