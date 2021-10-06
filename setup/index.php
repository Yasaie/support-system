<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    ob_start();
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Start Patronic installation</title>
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
				 * determine if an extension is loaded
				 *
				 * @param $name
				 * @return bool
				 */
				function extensionExists($name){
					return extension_loaded($name);
				}

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

				$phpversion=(version_compare(phpversion(), "5.6.4")>=1);

				$openssl=extensionExists('openssl');
				$pdo=extensionExists('pdo');
				$mbstring=extensionExists('mbstring');
				$tokenizer=extensionExists('tokenizer');
				$xml=extensionExists('xml');
				$curl=extensionExists('curl');

				$canInstall=false;

				if($phpversion && $openssl && $pdo && $mbstring && $tokenizer && $xml && $curl){
					$canInstall=true;
				}

			?>
			<div class="row">
				<div class="col-md-8 mx-auto">
					<span class="anchor" id="formUserEdit"></span>
					<!-- form user info -->
					<div class="card card-outline-secondary">
						<div class="card-body">

							<?php if($phpversion): ?>
							<div>
								<div class="text-center alert alert-success">
									<span class="pull-left">PHP version must be >= 5.6.4</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold"><?php echo phpversion(); ?></span>
										<span class="fa fa-check text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php else: ?>
							<div>
								<div class="text-center alert alert-danger">
									<span class="pull-left">PHP version must be >= 5.6.4</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold"><?php echo phpversion(); ?></span>
										<span class="fa fa-close text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php endif; ?>

							<?php if($openssl): ?>
							<div>
								<div class="text-center alert alert-success">
									<span class="pull-left">OpenSSL PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">Yes</span>
										<span class="fa fa-check text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php else: ?>
							<div>
								<div class="text-center alert alert-danger">
									<span class="pull-left">OpenSSL PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">No</span>
										<span class="fa fa-close text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php endif; ?>

							<?php if($pdo): ?>
							<div>
								<div class="text-center alert alert-success">
									<span class="pull-left">PDO PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">Yes</span>
										<span class="fa fa-check text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php else: ?>
							<div>
								<div class="text-center alert alert-danger">
									<span class="pull-left">PDO PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">No</span>
										<span class="fa fa-close text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php endif; ?>

							<?php if($mbstring): ?>
							<div>
								<div class="text-center alert alert-success">
									<span class="pull-left">Mbstring PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">Yes</span>
										<span class="fa fa-check text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php else: ?>
							<div>
								<div class="text-center alert alert-danger">
									<span class="pull-left">Mbstring PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">No</span>
										<span class="fa fa-close text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php endif; ?>

							<?php if($tokenizer): ?>
							<div>
								<div class="text-center alert alert-success">
									<span class="pull-left">Tokenizer PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">Yes</span>
										<span class="fa fa-check text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php else: ?>
							<div>
								<div class="text-center alert alert-danger">
									<span class="pull-left">Tokenizer PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">No</span>
										<span class="fa fa-close text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php endif; ?>

							<?php if($xml): ?>
							<div>
								<div class="text-center alert alert-success">
									<span class="pull-left">XML PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">Yes</span>
										<span class="fa fa-check text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php else: ?>
							<div>
								<div class="text-center alert alert-danger">
									<span class="pull-left">Tokenizer PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">No</span>
										<span class="fa fa-close text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php endif; ?>

							<?php if($curl): ?>
							<div>
								<div class="text-center alert alert-success">
									<span class="pull-left">cURL PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">Yes</span>
										<span class="fa fa-check text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php else: ?>
							<div>
								<div class="text-center alert alert-danger">
									<span class="pull-left">cURL PHP Extension</span>
									<span class="pull-right">
										<span class="text-white font-weight-bold">No</span>
										<span class="fa fa-close text-white font-weight-bold"></span>
									</span>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php endif; ?>

							<hr>

							<form action="part2.php"  method="GET" role="form" autocomplete="off">
								<?php if($canInstall): ?>
								<div class="form-group row">
									<div class="col-md-12">
										<button type="submit" class="pull-left btn btn-block btn-lg btn-primary">
											Install <span class="fa fa-smile-o"> </span>
										</button>
									</div>
								</div>
								<?php else: ?>
								<div class="form-group row">
									<div class="col-md-12">
										<button type="submit" class="pull-left btn btn-block btn-lg btn-primary" disabled>
											Install <span class="fa fa-frown-o"></span>
										</button>
									</div>
								</div>
								<?php endif; ?>
							</form>

						</div>
					</div>
					<!-- /form user info -->

				</div>
			</div>
		</div>
	</body>
</html>