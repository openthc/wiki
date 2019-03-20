<?php
/**
 * SkinTemplate class for the Timeless skin
 */

class SkinOpenTHC extends SkinTemplate
{
	public $skinname = 'openthc';
	public $stylename = 'OpenTHC';
	public $template = 'OpenTHC_Template';

	function initPage( OutputPage $out)
	{
		parent::initPage($out);
	}
}
