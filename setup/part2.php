<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    ob_start();
    session_start();
    include('DatabaseManager.php');
    //license
//    if(empty($_SESSION['license_username'])){
//        header('location:part1.php');
//    }
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Patronic installation part 2</title>
		<link rel="stylesheet" href="../public/css/bootstrap.min.css">
		<link rel="stylesheet" href="../public/css/font.css">
		<link rel="stylesheet" href="../public/css/icons.css">
		<style>
			body{
				background: url('../public/images/footer-bg.png') #FEFEFE fixed;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid py-5">
            <?php
                /**
                 * Get post value
                 *
                 * @param $name
                 * @return string
                 */
                function post($name){
                    if(!empty($_POST[$name])){
                        return trim($_POST[$name]);
                    }
                }
            ?>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <span class="anchor" id="formUserEdit"></span>
                    <!-- form user info -->
                    <div class="card card-outline-secondary">
                        <div class="card-body">
                            <?php
                                if($_SERVER['REQUEST_METHOD']=="POST"){
                                    $db_host=post('db_host');
                                    $db_port=post('db_port');
                                    $db_name=post('db_name');
                                    $db_username=post('db_username');
                                    $db_password=post('db_password');
                                    //determine if db given configs is true:
                                    try{
                                        $pdo=new PDO('mysql:host='.$db_host.';dbname='.$db_name,$db_username,$db_password);
                                        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                                        $pdo->exec('set names utf8');
                                        //set configs in session for further usages
                                        $_SESSION['db_host']=$db_host;
                                        $_SESSION['db_port']=$db_port;
                                        $_SESSION['db_name']=$db_name;
                                        $_SESSION['db_username']=$db_username;
                                        $_SESSION['db_password']=$db_password;

                                        //create Env file
                                        $env_path='exports/.env';
                                        if(file_exists($env_path)){
                                            $env=file_get_contents($env_path);
                                            $env=str_replace('DB_CONNECTION=','DB_CONNECTION=mysql',$env);
                                            $env=str_replace('DB_HOST=','DB_HOST='.$db_host,$env);
                                            $env=str_replace('DB_PORT=','DB_PORT='.$db_port,$env);
                                            $env=str_replace('DB_DATABASE=','DB_DATABASE='.$db_name,$env);
                                            $env=str_replace('DB_USERNAME=','DB_USERNAME='.$db_username,$env);
                                            $env=str_replace('DB_PASSWORD=','DB_PASSWORD='.$db_password,$env);
                                            //create env file and save configs:
                                            file_put_contents('../.env',$env);

                                            //create database tables:
                                            $manager=new \setup\DatabaseManager();
                                            $manager->addTables();

                                            //redirect to next part:
                                            return header('location:part3.php');
                                        }
                                        //env file not exists:
                                        throw new Exception('Template .env at "setup/exports/.env" not found!');
                                    }catch(Exception $exception){
                            ?>
                                    <div>
                                        <div class="text-center alert alert-danger">
                                            <span class="pull-left"><?php echo $exception->getMessage(); ?></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                            <?php
                                    }
                                }
                            ?>
                            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"  method="POST" role="form" autocomplete="off">
                                <h4 class="text-center">Database configs</h4>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label form-control-label">Database's Host</label>
                                    <div class="col-md-9">
                                        <input name="db_host" class="form-control" type="text" placeholder="host" value="<?php echo (post('db_host') ? post('db_host') : 'localhost'); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label form-control-label">Database's Port</label>
                                    <div class="col-md-9">
                                        <input name="db_port" class="form-control" type="text" placeholder="port" value="<?php echo (post('db_port') ? post('db_port') : '3306'); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label form-control-label">Database's Name</label>
                                    <div class="col-md-9">
                                        <input name="db_name" class="form-control" type="text" placeholder="name" value="<?php echo post('db_name'); ?>" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label form-control-label">Database's Username</label>
                                    <div class="col-md-9">
                                        <input name="db_username" class="form-control" type="text" placeholder="username" value="<?php echo post('db_username'); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label form-control-label">Database's Password</label>
                                    <div class="col-md-9">
                                        <input name="db_password" class="form-control" type="text" placeholder="password" value="<?php echo post('db_password'); ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label form-control-label"></label>
                                    <div class="col-md-9">
                                        <input type="submit" class="pull-left btn btn-primary" value="Install">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /form user info -->

                </div>
            </div>
		</div>
	</body>
</html>