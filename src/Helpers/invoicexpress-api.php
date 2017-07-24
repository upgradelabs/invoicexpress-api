<?php

if (!function_exists('endpoint_replace')) {

	/**
	 * @param array $values
	 * @param string $string
	 *
	 * @return string
	 */
	function endpoint_replace(array $values, string $string) :string
	{
		preg_match_all("/{(.*?)}/", $endpoint, $output);

		$b = count($output[0]);
		$v = count($values);
		($b === $v) ?: throwException("Number of items to replace differs from what to replace");

		for ($i = 0; $i < $b; $i++) {
			$endpoint = str_replace($output[0][$i], $values[$i], $endpoint);
		}
		return $endpoint;
	}
}