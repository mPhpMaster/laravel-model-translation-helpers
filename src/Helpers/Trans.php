<?php
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

if( !function_exists('getTrans') ) {
	/**
	 * Translate the given message or return default.
	 *
	 * @param string|null                $key
	 * @param string|\Closure|mixed|null $default
	 * @param array                      $replace
	 * @param string|null                $locale
	 *
	 * @return string|array|null
	 */
	function getTrans($key = null, $default = null, $replace = [], $locale = null)
	{
		$key = value($key);
		$return = __($key, $replace, $locale);
		
		return $return === $key ? value($default) : $return;
	}
}
