<?php
/* SVN FILE: $Id$ */
/**
 * Sass_tree_SassDirectiveNode class file.
 * @author			Chris Yates <chris.l.yates@gmail.com>
 * @copyright 	Copyright (c) 2010 PBM Web Development
 * @license			http://phamlp.googlecode.com/files/license.txt
 * @package			PHamlP
 * @subpackage	Sass.tree
 */

/**
 * Sass_tree_SassDirectiveNode class.
 * Represents a CSS directive.
 * @package			PHamlP
 * @subpackage	Sass.tree
 */
class Sass_tree_SassDirectiveNode extends SassNode {
	const NODE_IDENTIFIER = '@';
	const MATCH = '/^(@\w+)/';

	/**
	 * Sass_tree_SassDirectiveNode.
	 * @param object source token
	 * @return Sass_tree_SassDirectiveNode
	 */
	public function __construct($token) {
		parent::__construct($token);
	}
	
	protected function getDirective() {
		return self::extractDirective($this->token);
	}

	/**
	 * Parse this node.
	 * @param Sass_tree_SassContext the context in which this node is parsed
	 * @return array the parsed node
	 */
	public function parse($context) {
		$this->children = $this->parseChildren($context);
		return array($this);
	}

	/**
	 * Render this node.
	 * @return string the rendered node
	 */
	public function render() {
		$properties = array();
		foreach ($this->children as $child) {
			$properties[] = $child->render();
		} // foreach

		return $this->renderer->renderDirective($this, $properties);
	}

	/**
	 * Returns a value indicating if the token represents this type of node.
	 * @param object token
	 * @return boolean true if the token represents this type of node, false if not
	 */
	public static function isa($token) {
		return $token->source[0] === self::NODE_IDENTIFIER;
	}

	/**
	 * Returns the directive
	 * @param object token
	 * @return string the directive
	 */
	public static function extractDirective($token) {
		preg_match(self::MATCH, $token->source, $matches);
	  return strtolower($matches[1]);
	}
}