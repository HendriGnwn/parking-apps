<?php

namespace app\helpers;

use yii\helpers\StringHelper as BaseStringHelper;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StringHelper extends BaseStringHelper
{
	/**
	 * @return array
	 */
	public static function listIndoMonths()
	{
		return [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		];
	}
	
	public static function listOldParkings()
	{
		$result = [];
		for ($i=0;$i<25;$i++) {
			$result[$i] = [
				'name' => $i . ' Jam',
				'compare' => '=',
				'value' => $i,
			];
		}
		$result[25] = [
				'name' => '> 24 Jam',
				'compare' => '>',
				'value' => 24,
			];
		
		return $result;
	}
}