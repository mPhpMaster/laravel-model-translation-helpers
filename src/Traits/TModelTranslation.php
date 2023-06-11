<?php
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace MPhpMaster\LaravelModelTranslationHelpers\Traits;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait TModelTranslation
{
	/**
	 * Returns translations file name.
	 *
	 * @return string|null
	 */
	public static function getTranslationKey(): ?string
	{
		return str_singular(snake_case((new static)->getTable()));
	}
	
	/**
	 * Encode the given value as JSON.
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	protected function asJson($value)
	{
		return json_encode($value, JSON_UNESCAPED_UNICODE);
	}
	
	/**
	 * alias for __("models/model_name") and __("models/model_name.fields.field_name")
	 *
	 * @param string               $key
	 * @param array                $replace
	 * @param string|null          $locale
	 * @param string|\Closure|null $default
	 *
	 * @return array|string|null
	 */
	public static function trans($key = null, $replace = [], $locale = null, $default = null)
	{
		$transKey = static::getTranslationKey() ?? (new static)->getTable();
		$models = [
			str_singular(snake_case($transKey)),
			str_plural(snake_case($transKey)),
			
			str_singular(snake_case(class_basename(static::class))),
			str_plural(snake_case(class_basename(static::class))),
		];
		
		$replace = !is_array($replace = value($replace)) ? array_wrap($replace) : $replace;
		$default = is_null($default = value($default)) ? $key : $default;
		
		$result = null;
		foreach ($models as $model) {
			if ( $result = getTrans(
				"models/{$model}" . (is_null($key) ? "" : ".{$key}"),
				fn() => is_null($key) ? null : getTrans(
					"models/{$model}.fields.{$key}",
					null,
					
					$replace,
					$locale
				),
				$replace,
				$locale
			) ) {
				break;
			}
		}
		$result ??= value($default);
		
		if ( $result === $key ) {
			$result = $result === 'plural' ? str_plural($model) : ($result === 'singular' ? str_singular($model) : $result);
			$result = $result ? \Str::headline($result) : $result;
		}
		
		return $result;
	}
}
