<?php
    $time=15*60;//15 min
    ini_set('max_execution_time',$time);
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
		<title>Import AH-Tickets' data</title>
		<link rel="stylesheet" href="../../public/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../public/css/font.css">
		<link rel="stylesheet" href="../../public/css/icons.css">
		<style>
			body{
				background: url('../../public/images/footer-bg.png') #FEFEFE fixed;
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

					$canImport=false;

					if($phpversion && $openssl && $pdo && $mbstring){
						$canImport=true;
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
                                        $old_db_host=post('old_db_host');
                                        $old_db_port=post('old_db_port');
                                        $old_db_name=post('old_db_name');
                                        $old_db_username=post('old_db_username');
                                        $old_db_password=post('old_db_password');

										$db_host=!empty($_SESSION['db_host'])?$_SESSION['db_host']:post('db_host');
										$db_port=!empty($_SESSION['db_port'])?$_SESSION['db_port']:post('db_port');
										$db_name=!empty($_SESSION['db_name'])?$_SESSION['db_name']:post('db_name');
										$db_username=!empty($_SESSION['db_username'])?$_SESSION['db_username']:post('db_username');
										$db_password=!empty($_SESSION['db_password'])?$_SESSION['db_password']:post('db_password');

                                        //determine if db given configs is true:
                                        try{
											//connection to old db
											$old_pdo=new PDO('mysql:host='.$old_db_host.';dbname='.$old_db_name,$old_db_username,$old_db_password);
											$old_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
											$old_pdo->exec('set names utf8');

											//connection to new db
											$pdo=new PDO('mysql:host='.$db_host.';dbname='.$db_name,$db_username,$db_password);
											$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
											$pdo->exec('set names utf8');

                                            //set configs in session for further usages
											$_SESSION['old_db_host']=$old_db_host;
											$_SESSION['old_db_port']=$old_db_port;
											$_SESSION['old_db_name']=$old_db_name;
											$_SESSION['old_db_username']=$old_db_username;
											$_SESSION['old_db_password']=$old_db_password;

											$_SESSION['db_host']=$db_host;
											$_SESSION['db_port']=$db_port;
											$_SESSION['db_name']=$db_name;
											$_SESSION['db_username']=$db_username;
											$_SESSION['db_password']=$db_password;

											//import users:
                                            $query="select * from users";
                                            $users=$old_pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
                                            if(!empty($users)){
                                                foreach($users as $user){

                                                    $name=$user['name'];
                                                    $email=$user['email'];
                                                    $mobile=$user['phone'];
                                                    $is_admin=$user['is_admin'];
													$email_verified_at=$mobile_verified_at=$created_at=$updated_at=date('Y/m/d H:i:s',$user['register_time']);
													$biography=$user['bio'];
													$gender=$user['gender'];

                                                    //check if user exists:
                                                    $query="select * from users where email='$email'";
													$exists=$pdo->query($query)->fetchAll();
                                                    if(!empty($exists)){
														//if this user exists or is admin , import next one
                                                        continue;
                                                    }
                                                    if($mobile){
														$query="insert into users (is_admin,email,mobile,email_verified_at,mobile_verified_at,created_at,updated_at) values ('$is_admin','$email','$mobile','$email_verified_at','$mobile_verified_at','$created_at','$updated_at')";
													}else{
														$query="insert into users (is_admin,email,email_verified_at,created_at,updated_at) values ('$is_admin','$email','$email_verified_at','$created_at','$updated_at')";
													}
													$pdo->query($query);
													$user_id=$pdo->lastInsertId();
													$query="insert into users_meta (name,gender,biography,user_id,created_at,updated_at) values ('$name','$gender','$biography','$user_id','$created_at','$updated_at')";
													$pdo->query($query);
                                                }
                                            }

											//import departments:

                                            $query="select * from departments left join stuff_relations on d_id=stuff_departments";
                                            $departments=$old_pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
                                            if(!empty($departments)){
                                                foreach($departments as $department){
                                                    $name=$department['d_name'];
													$created_at=$updated_at=date('Y/m/d H:i:s',$department['d_time']);
                                                    $user_id=null;

                                                    //check if department exists:
                                                    $query="select * from departments where name='$name'";
													$exists=$pdo->query($query)->fetchAll();
                                                    if(!empty($exists)){
                                                        continue;//this department exists , import next one
                                                    }

                                                    //get staff_id in new database
                                                    if(!empty($users)){
														$user_index=array_search($department['stuff_id'],array_column($users,'id'));
														if($user_index!==false){
															$user_email=$users[$user_index]['email'];
															if(!empty($user_email)){
																$query="select * from users where email='$user_email'";
																$staff=$pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
																if(!empty($staff)){
																	$user_id=$staff[0]['id'];
																}
															}
														}
													}

													$query="insert into departments (name,created_at,updated_at) values ('$name','$created_at','$updated_at')";
													$pdo->query($query);
													$department_id=$pdo->lastInsertId();
													//import staffs
													if(!empty($user_id)){
														$query="insert into departments_users (department_id,user_id,created_at,updated_at) values ('$department_id','$user_id','$created_at','$updated_at')";
														$pdo->query($query);
													}

                                                }
                                            }

                                            //import news

                                            $query="select * from users where is_owner=1 or is_admin=1";
                                            $user=$pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
                                            if(!empty($user)){

                                                $user_id=$user[0]['id'];
                                                $query="select * from posts";
                                                $news=$old_pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($news as $new){
                                                    $title=$new['post_title'];
                                                    $content=$new['post_content'];
													$created_at=$updated_at=date('Y/m/d H:i:s',$new['post_time']);
													$published_at=null;
													$department_id=null;

													if($new['is_public']){
														$published_at=$created_at;
													}

                                                    //check if news exists:
                                                    $query="select * from news where title='$title'";
													$exists=$pdo->query($query)->fetchAll();
                                                    if(!empty($exists)){
                                                        continue;//this news exists , import next one
                                                    }

                                                    //get department_id in new database
                                                    if(!empty($departments)){
														$department_index=array_search($new['post_department'],array_column($departments,'d_id'));
														if($department_index!==false){
															$department_name=$departments[$department_index]['d_name'];
															if(!empty($department_name)){
																$query="select * from departments where name='$department_name'";
																$department=$pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
																if(!empty($department)){
																	$department_id=$department[0]['id'];
																}
															}
														}
                                                    }

													$query="insert into news (user_id,title,content,published_at,created_at,updated_at) values ('$user_id','$title','$content','$published_at','$created_at','$updated_at')";
                                                    $pdo->query($query);
                                                    $new_id=$pdo->lastInsertId();

													//import news into their departments
													if(!empty($department_id)){
														$query="insert into news_departments (news_id,department_id,created_at,updated_at) values ('$new_id','$department_id','$created_at','$updated_at')";
														$pdo->query($query);
													}
                                                }

                                            }

                                            //import tickets

                                            $query="select * from tickets order by parent_id,t_id asc";
                                            $tickets=$old_pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

                                            foreach($tickets as $ticket){
                                                $id = $ticket['t_id'];
                                                $subject = $ticket['subject'];
												$content = nl2br(strip_tags($ticket['content']));

                                                $user_id=null;
                                                $department_id=null;

												$ticket_id = (!empty($ticket['parent_id'])?$ticket['parent_id']:null);

												$priority = $ticket['priority'];
                                                if($priority=='low'){
                                                    $priority=1;
                                                }elseif($priority=='medium'){
                                                    $priority=2;
                                                }elseif($priority='high'){
                                                    $priority=3;
                                                }elseif($priority='emergency'){
                                                    $priority=4;
                                                }else{
                                                    $priority=4;
                                                }

                                                $status = $ticket['status'];
                                                if($status==1){
                                                    $status=1;
                                                }else{
                                                    $status=2;
                                                }

                                                $created_at = $updated_at = date('Y/m/d H:i:s', $ticket['time']);

                                                //get user_id in new database
                                                if(!empty($users)){
                                                    $user_index=array_search($ticket['user_id'],array_column($users,'id'));
                                                    if($user_index!==false){
                                                        $user_email=$users[$user_index]['email'];
                                                        if(!empty($user_email)){
                                                            $query="select * from users where email='$user_email'";
                                                            $staff=$pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
                                                            if(!empty($staff)){
                                                                $user_id=$staff[0]['id'];
                                                            }
                                                        }
                                                    }
                                                }

                                                //get department_id in new database
                                                if(!empty($departments)){
                                                    $department_index=array_search($ticket['department'],array_column($departments,'d_id'));
                                                    if($department_index!==false){
                                                        $department_name=$departments[$department_index]['d_name'];
                                                        if(!empty($department_name)){
                                                            $query="select * from departments where name='$department_name'";
                                                            $department=$pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
                                                            if(!empty($department)){
                                                                $department_id=$department[0]['id'];
                                                            }
                                                        }
                                                    }
                                                }

                                                //reply tickets don't need department
                                                if($user_id && ($department_id || $ticket_id)){
                                                    if($ticket_id){
                                                        //check if parent ticket exists:
                                                        $query="select * from tickets where id=$ticket_id";
                                                        $exists=$pdo->query($query)->rowCount();
                                                        if($exists<=0){
                                                            continue;
														}
														$query="insert into tickets (id,user_id,ticket_id,subject,status,priority,content,created_at,updated_at) values 
                                                                                    ('$id','$user_id','$ticket_id','$subject','$status','$priority','$content','$created_at','$updated_at')";
													}else{
														$query="insert into tickets (id,user_id,subject,department_id,status,priority,content,created_at,updated_at) values ('$id','$user_id','$subject','$department_id','$status','$priority','$content','$created_at','$updated_at')";
													}
													$pdo->query($query);
												}

                                            }

                                            ?>
                                                <div>
                                                    <div class="text-center alert alert-success">
                                                        <span class="pull-left">old data has been imported successfully</span>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            <?php
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
                                <?php if(empty($_SESSION['db_host'])): ?>
									<h4 class="text-center">New database</h4>
									<hr>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label">Database's Host</label>
										<div class="col-md-9">
											<input name="db_host" class="form-control" type="text" placeholder="host" value="<?php echo (post('old_db_host') ? post('db_host') : 'localhost'); ?>" required>
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
                                <?php endif; ?>
									<h4 class="text-center">Old database</h4>
									<hr>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label">Database's Host</label>
										<div class="col-md-9">
											<input name="old_db_host" class="form-control" type="text" placeholder="host" value="<?php echo (post('old_db_host') ? post('old_db_host') : 'localhost'); ?>" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label">Database's Port</label>
										<div class="col-md-9">
											<input name="old_db_port" class="form-control" type="text" placeholder="port" value="<?php echo (post('old_db_port') ? post('old_db_port') : '3306'); ?>" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label">Database's Name</label>
										<div class="col-md-9">
											<input name="old_db_name" class="form-control" type="text" placeholder="name" value="<?php echo post('old_db_name'); ?>" required autofocus>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label">Database's Username</label>
										<div class="col-md-9">
											<input name="old_db_username" class="form-control" type="text" placeholder="username" value="<?php echo post('old_db_username'); ?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label">Database's Password</label>
										<div class="col-md-9">
											<input name="old_db_password" class="form-control" type="text" placeholder="password" value="<?php echo post('old_db_password'); ?>">
										</div>
									</div>

									<?php if($canImport): ?>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label"></label>
										<div class="col-md-9">
											<input type="submit" class="pull-left btn btn-primary" value="Import datas">
										</div>
									</div>
									<?php else: ?>
									<div class="form-group row">
										<label class="col-md-3 col-form-label form-control-label"></label>
										<div class="col-md-9">
											<input type="button" class="pull-left btn btn-primary" disabled value="Import datas">
										</div>
									</div>
									<?php endif; ?>
								</form>

								<hr>

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

							</div>
						</div>
						<!-- /form user info -->

					</div>
				</div>
		</div>
	</body>
</html>