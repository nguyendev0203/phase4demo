<?php

namespace Team2\MultipleLayeredNavigation\Model\Url;

class Builder extends \Magento\Framework\Url {

	public function getFilterUrl($code, $value, $query = [], $singleValue = false){
		$params = ['_current' => true, '_use_rewrite' => true, '_query' => $query];
		$values = array_unique(
			array_merge(
				$this->getValuesFromUrl($code), 
				[$value]
			)
		);
		$params['_query'][$code] = implode(',', $values);

		$newUrl = $this->removePageFilterFromUrl($this->getUrl('*/*/*', $params));

		// return urldecode($this->getUrl('*/*/*', $params));
		return $newUrl;
	}

	public function getRemoveFilterUrl($code, $value, $query = []){
		$params = ['_current' => true, '_use_rewrite' => true, '_query' => $query, '_escape' => true];
		$values = $this->getValuesFromUrl($code);

		$key = array_search($value, $values);
		unset($values[$key]);
		$params['_query'][$code] = $values ? implode(',', $values) : null;

		$newUrl = $this->removePageFilterFromUrl($this->getUrl('*/*/*', $params));

		// return urldecode($this->getUrl('*/*/*', $params));
		return $newUrl;
	}

	public function getValuesFromUrl($code){
		return array_filter(explode(',', $this->_getRequest()->getParam($code)));
	}

	public function removePageFilterFromUrl($url){
		$parts = parse_url(urldecode($url));

		if (isset($parts['query'])) {
			$urlVar = "";                   
			$urlVar = $parts['query'];
			$urlVar = preg_replace('/&?p=[0-9]/', '', $urlVar);

			if (isset($parts['port'])) {
				$newUrl = "{$parts['scheme']}://{$parts['host']}:{$parts['port']}{$parts['path']}?" . $urlVar;
			} else {
				$newUrl = "{$parts['scheme']}://{$parts['host']}{$parts['path']}?" . $urlVar;
			}
			return $newUrl;
		} else {
			return urldecode($url);
		}
	}
}