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
    <title>Patronic installation part 3</title>
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
                    $manager=new \setup\DatabaseManager();
                    if($_SERVER['REQUEST_METHOD']=="POST"){
                        $username=post('db_host');
                        $password=post('db_port');

                        $migration=false;
                        $seed=false;
                        //determine if db given configs is true:
                        try{
                            if(!$manager->ownerExists()){
								$manager->addOwnerUser();
							}
                            $manager->setSiteGeneralConfigs();
                            $manager->copyDatas();
                            //redirect to main page part:
                            return header('location:../panel/config/general');
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
                    <div>
                        <div dir="rtl" class="text-center alert alert-info">
                            <span class="pull-left">After installation ,remove <b>setup</b> and <b>public</b> folders</span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"  method="POST" role="form" autocomplete="off">
                        <?php if(!$manager->ownerExists()): ?>
                        <h4 class="text-center">Owner user configs</h4>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label form-control-label">name</label>
                            <div class="col-md-9">
                                <input name="name" class="form-control" type="text" placeholder="name" value="<?php echo post('name'); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label form-control-label">Email</label>
                            <div class="col-md-9">
                                <input name="email" class="form-control" type="email" placeholder="E-mail" value="<?php echo post('email'); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label form-control-label">Password</label>
                            <div class="col-md-9">
                                <input name="password" class="form-control" type="text" placeholder="password" value="<?php echo post('password'); ?>" required>
                            </div>
                        </div>
                        <hr>
                        <?php endif; ?>
                        <h4 class="text-center">site general configs</h4>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label form-control-label">site address</label>
                            <div class="col-md-9">
                                <input name="site_address" class="form-control" type="url" placeholder="http://www.yoursite.com" value="<?php echo (empty(post('site_address')) ? url() : post('site_address')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label form-control-label"></label>
                            <div class="col-md-9">
                                <input type="submit" class="pull-left btn btn-primary" value="Install">
                            </div>
                        </div>
                        <hr>
                        <p class="text-muted text-right">Instalation may take about 20 minutes , be patient.</p>
                        <p class="text-muted text-right">If you have any question visit : <a target="_blank" href="https://www.patronic.ir">Patronic.ir</a></p>
                    </form>
                </div>
            </div>
            <!-- /form user info -->

        </div>
    </div>
</div>
</body>
</html>