<?php
namespace App\Http\Controllers\Config;

use App\Config;

class getConfig {
	public static function load($config_name){
		$config=Config::where('name','=',$config_name)->get();
		if($config->isNotEmpty()){

			//retrieve config value:
			$config_value=$config->first()->value;

			switch($config_name){
				case 'ticket_attachment_file_formats'://return file formats array
					if(empty($config_value)){
						return [];//empty array
					}
					$fileFormats=explode('|',$config_value);
					return $fileFormats;
				break;
				default:
					return $config_value;
				break;
			}

		}
		return null;
	}

	public static function has_ticket_attachment_file_format($file_format){
		$fileFormats=self::load('ticket_attachment_file_formats');
		if(in_array($file_format,$fileFormats)){
			return true;
		}
		return false;
	}

	public function __get($name)
	{
		return self::load($name);
	}

	public static function __callStatic($name, $arguments)
	{
		return self::load($name);
	}
}
