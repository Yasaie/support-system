<?php
namespace setup;

class DatabaseManager {

	private $db_connection;

	public function __construct()
	{
		$min=20*60;//20 min execution

		ini_set('max_execution_time',$min);
		set_time_limit($min);

		//get database configs
		$db_host=!empty($_SESSION['db_host'])?$_SESSION['db_host']:'';
		$db_name=!empty($_SESSION['db_name'])?$_SESSION['db_name']:'';
		$db_username=!empty($_SESSION['db_username'])?$_SESSION['db_username']:'';
		$db_password=!empty($_SESSION['db_password'])?$_SESSION['db_password']:'';

		//connect to database
		$this->db_connection=mysqli_connect($db_host,$db_username,$db_password,$db_name);
		mysqli_set_charset($this->db_connection,'utf8');
		if(mysqli_error($this->db_connection)){
			throw new \Exception(mysqli_error($this->db_connection));
		}
	}

	public function addTables(){
		$tables=[
			'users'					=>'exports/sql/2014_10_12_000000_create_users_table.sql',
			'password_resets'		=>'exports/sql/2014_10_12_100000_create_password_resets_table.sql',
			'countries'				=>'exports/sql/2018_02_17_183207_create_countries_table.sql',
			'departments'			=>'exports/sql/2018_02_17_185415_create_departments_table.sql',
			'configs'				=>'exports/sql/2018_02_17_185748_create_configs_table.sql',
			'tickets'				=>'exports/sql/2018_02_17_190323_create_tickets_table.sql',
			'rates'					=>'exports/sql/2018_02_17_194034_create_rates_table.sql',
			'medias'				=>'exports/sql/2018_02_17_194521_create_medias_table.sql',
			'medias_pivot'			=>'exports/sql/2018_02_17_195419_create_medias_pivot_table.sql',
			'departments_users'		=>'exports/sql/2018_02_17_195938_create_departments_users_table.sql',
			'users_meta'			=>'exports/sql/2018_02_17_202141_create_users_meta_table.sql',
			'sms_logs'				=>'exports/sql/2018_02_17_204527_create_sms_logs_table.sql',
			'notifications'			=>'exports/sql/2018_02_17_204832_create_notifications_table.sql',
			'notification_recipient'=>'exports/sql/2018_02_17_205645_create_notification_recipient_table.sql',
			'provinces'				=>'exports/sql/2018_02_17_210835_create_provinces_table.sql',
			'cities'				=>'exports/sql/2018_02_17_210857_create_cities_table.sql',
			'news'					=>'exports/sql/2018_02_17_212200_create_news_table.sql',
			'views'					=>'exports/sql/2018_02_17_213212_create_views_table.sql',
			'likes'					=>'exports/sql/2018_02_17_213432_create_likes_table.sql',
			'news_departments'		=>'exports/sql/2018_04_19_112551_create_news_departments_table.sql',
			'faqs'					=>'exports/sql/2018_04_19_113018_create_faqs_table.sql',
			'roles'					=>'exports/sql/2018_06_02_091514_create_roles_table.sql',
			'permissions'			=>'exports/sql/2018_06_02_092208_create_permissions_table.sql',
			'roles_permissions'		=>'exports/sql/2018_06_02_101532_create_roles_permissions_table.sql',
			'users_roles'			=>'exports/sql/2018_06_02_101824_create_users_roles_table.sql',
		];

		$tables_need_update=['configs','views'];

		foreach($tables as $table_name=>$table){


			if(in_array($table_name,$tables_need_update)){
				mysqli_query($this->db_connection,'DROP TABLE `'.$table_name.'`');
			}else{
				if(!in_array($table_name,$tables_need_update)){
					$checkTableExistsQuery = 'SELECT 1 FROM `'.$table_name.'` LIMIT 1';
					$exists=mysqli_query($this->db_connection,$checkTableExistsQuery);
					$checkTableExistsQuery=null;
					if($exists!==false){
						continue;
					}
				}
			}

			if(file_exists($table)){
				// Temporary variable, used to store current query
				$templine = '';
				// Read in entire file
				$lines = file($table);
				// Loop through each line
				foreach ($lines as $line){
					// Skip it if it's a comment
					if (substr($line, 0, 2) == '--' || $line == ''){
						continue;
					}
					// Add this line to the current segment
					$templine .= $line;
					// If it has a semicolon at the end, it's the end of the query
					if (substr(trim($line), -1, 1) == ';'){
						// Perform the query
						mysqli_query($this->db_connection,$templine);
						// Reset temp variable to empty
						$templine = '';
						if(mysqli_error($this->db_connection)){
							//die($table);
							throw new \Exception(mysqli_error($this->db_connection));
							return;
						}
					}
				}
			}else{
				throw new \Exception('setup/'.$table.' not found!');
				break;
			}
		}
	}

	public function input($name){
		if(!empty($_POST[$name])){
			return $_POST[$name];
		}
	}

	public function ownerExists(){
		$query="select * from `users` where is_owner=1";
		$result=mysqli_query($this->db_connection,$query);
		if(mysqli_num_rows($result)>0){
			return true;
		}
		return false;
	}

	public function addOwnerUser(){
		$userData=[
			'email'						=> mysqli_real_escape_string($this->db_connection,$this->input('email')),
			'is_owner'					=> 1,
			'is_admin'					=> 0,
			'email_verified_at'			=> (date('Y-m-d H:i:s')),
			'password' 					=> password_hash($this->input('password'), PASSWORD_BCRYPT),
		];

		$query="insert into `users` (email,is_owner,is_admin,email_verified_at,password) 
				values
				(
				 '".$userData['email']."',
				  ".$userData['is_owner'].",
				 '".$userData['is_admin']."',
				 '".$userData['email_verified_at']."',
				 '".$userData['password']."'
				 )";

		mysqli_query($this->db_connection,$query);

		if(mysqli_error($this->db_connection)){
			throw new \Exception(mysqli_error($this->db_connection));
			return;
		}

		$user_id=mysqli_insert_id($this->db_connection);

		//create user's meta
		$userMetaData=[
			'name'				=> $this->input('name'),
			'user_id'			=> $user_id,
		];

		$query="insert into `users_meta` (`name`,user_id)
				values
				(
				 '".$userMetaData['name']."',
				 '".$userMetaData['user_id']."'
				)";

		mysqli_query($this->db_connection,$query);

		if(mysqli_error($this->db_connection)){
			throw new \Exception(mysqli_error($this->db_connection));
		}
	}
	
	public function setSiteGeneralConfigs(){
		$site_address=post('site_address');
		if(empty($site_address) || !filter_var($site_address,FILTER_VALIDATE_URL)){
			throw new \Exception('site address has wrong pattern');
			return;
		}
		$site_address=mysqli_real_escape_string($this->db_connection,$site_address);
		$query="UPDATE `configs` SET `value`='".$site_address."' WHERE `name`='site_address'";
		mysqli_query($this->db_connection,$query);

		if(mysqli_error($this->db_connection)){
			throw new \Exception(mysqli_error($this->db_connection));
		}
	}

	public function copyDatas($source="../public/",$destination="../"){
		$dir = opendir($source);
		if(!file_exists($destination)){
			@mkdir($destination);
		}
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($source . '/' . $file) ) {
					$this->copyDatas($source . '/' . $file,$destination . '/' . $file);
				}
				else {
					copy($source . '/' . $file,$destination . '/' . $file);
				}
			}
		}
		closedir($dir);
	}
	public function __destruct()
	{
		$this->db_connection=null;
	}
}
