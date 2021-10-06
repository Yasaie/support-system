<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    ob_start();
    session_start();
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Patronic installation part 1</title>
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

                    /**
                     * @return string
                     */
                    function url(){
                        return sprintf(
                            "%s://%s",
                            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
                            $_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'/setup'))
                        );
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
                                        $license_username=post('license_username');
                                        $license_order_id=post('license_order_id');
                                        $site_domain=post('site_domain');
                                        //determine if db given configs is true:
                                        try{
                                            function send($api,$username,$order_id,$domain){
                                                $url = 'http://www.rtl-theme.com/oauth/';
                                                $ch = curl_init();
                                                curl_setopt($ch,CURLOPT_URL,$url);
                                                curl_setopt($ch,CURLOPT_POSTFIELDS,"api=$api&username=$username&order_id=$order_id&domain=$domain");
                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                                                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                                                $res = curl_exec($ch);
                                                curl_close($ch);
                                                return $res;
                                            }
                                            $api = 'rtl51f6b578529f47b1123cd6bf58ed00';
                                            $result = send($api,$license_username,$license_order_id,$site_domain);

                                            switch ($result) {
                                                case '1':
                                                    $_SESSION['license_username']=$license_username;
                                                    $_SESSION['license_order_id']=$license_order_id;
                                                    $_SESSION['site_domain']=$site_domain;
                                                    //redirect to next part:
                                                    header('location:part2.php');
                                                    return;
                                                    break;
                                                case '-1':
                                                    throw new Exception('API is not valid.');
                                                    break;
                                                case '-2':
                                                    throw new Exception('username is wrong.');
                                                    break;
                                                case '-3':
                                                    throw new Exception('order id is wrong.');
                                                    break;
                                                case '-4':
                                                    throw new Exception('order id has been used.');
                                                    break;
                                                case '-5':
                                                    throw new Exception('the order id has no relation with username.');
                                                    break;
                                                default:
                                                    throw new Exception('unknown error!');
                                                    break;
                                            }
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
									<h4 class="text-center">Checking License (by rtl-theme)</h4>
									<hr>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label">rtl-theme username</label>
										<div class="col-md-9">
											<input name="license_username" class="form-control" type="text" placeholder="username" value="<?php echo (post('license_username') ? post('license_username') : ''); ?>" required autofocus>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label">rtl-theme order id</label>
										<div class="col-md-9">
											<input name="license_order_id" class="form-control" type="text" placeholder="order id" value="<?php echo (post('license_order_id') ? post('license_order_id') : ''); ?>" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label">your site domain</label>
										<div class="col-md-9">
											<input name="site_domain" class="form-control" type="url" placeholder="domain" value="<?php echo (post('site_domain') ? post('site_domain') : url()); ?>" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label"></label>
										<div class="col-md-9">
											<button type="submit" class="pull-left btn btn-primary">
											    Next
                                            </button>
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