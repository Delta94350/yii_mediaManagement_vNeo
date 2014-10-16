<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Medias management</title>

   <!-- Bootstrap Core CSS -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/ressources/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/ressources/css/style.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/ressources/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/ressources/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/ressources/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<?php if(!isset(Yii::app()->session['activeTab'])) { Yii::app()->session['activeTab'] = 'seriesTab'; } ?>
<?php
    $pos = strpos(Yii::app()->session['activeTab'], 'sTab');
    $form = substr(Yii::app()->session['activeTab'], 0, $pos);
?>
<?php $status = Status::model()->findAll(); ?>
<body onload="setActiveTab('<?php echo Yii::app()->session['activeTab']; ?>')">
    <div id="question" style="display:none; cursor: default"> 
        <h4>Are you sure ?</h4> 
        <input id="questionYes" type="button" id="yes" value="Yes" /> 
        <input type="button" id="no" value="No" onclick="hideModalBlock('body');"/>
        <br />
    </div> 
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/index.php">Medias Management v.Neo</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-left top-nav">
                <form method="POST" action="/index.php/<?php echo $form; ?>/add" class="navbar-form form-inline" role="form">
                    <div class="form-group">
                        <div class="input-group">
                              <div class="input-group-addon"><span class="glyphicon glyphicon-film"></span></div>
                              <input id="inputTitle" name="inputTitle" class="form-control" type="text" placeholder="Title ..." required>
                        </div>
                        <select id="selectStatus" name="selectStatus" class="form-control">
                            <?php foreach($status as $statu) { ?>
                                <option class="bg-<?php echo $statu->css; ?>" 
                                        value="<?php echo $statu->id; ?>">
                                            <?php echo $statu->description; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button class="btn btn-default" type="submit">Add</button>
                    </div>
                </form>
            </ul>
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo Yii::app()->request->cookies['login']; ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Lorem ipsu</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Lorem ipsu</a>
                        </li>
                        <li class="divider"></li>
                    </ul>
                </li>
                <!-- LogOut link-->
                <li>
                    <a href="/index.php/user/logout">
                        <span class="glyphicon glyphicon-log-out"></span>
                    </a>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li id="seriesTab">
                        <a href="/index.php/serie"><i class="fa fa-fw fa-film"></i> Series</a>
                    </li>
                    <li id="mangasTab">
                        <a href="/index.php/manga"><i class="fa fa-fw fa-leaf"></i> Mangas</a>
                    </li>
                    <li id="syncsTab">
                        <a href="/index.php/sync"><i class="fa fa-fw fa-laptop"></i> Syncs</a>
                    </li>
                    <li class="text-center">
                        <span id="quickImage"></span>
                    </li>
                    <!--
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                        </ul>
                    </li> -->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        
        <div id="page-wrapper">
            
                <?php
                    if(isset($_SESSION['success'])) {
                        if($_SESSION['success'] == true) {
                            if(isset($_SESSION['alertMessage'])) {
                                echo '<div class="alert alert-success alert-dismissible text-center" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><b>'.$_SESSION['alertMessage'].'</b></div>';
                            } else {
                                echo '<div class="alert alert-success alert-dismissible text-center" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><b> ERREUR </b></div>';
                            }
                        }
                        unset($_SESSION['success']);
                    } else if(isset(Yii::app()->session['error'])) {
                        if(Yii::app()->session['error'] == true) {
                            if(isset(Yii::app()->session['alertMessage'])) {
                                echo '<div class="alert alert-danger alert-dismissible text-center" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><b>'.Yii::app()->session['alertMessage'].'</b></div>';
                            } else {
                                echo '<div class="alert alert-danger alert-dismissible text-center" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><b> ERREUR </b></div>';
                            }
                        }
                        unset(Yii::app()->session['error']);
                    }
                ?>

                <?php echo $content; ?>
                
           
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        
    </div>

        

    <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/ressources/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/ressources/js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/ressources/js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/ressources/js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/ressources/js/plugins/morris/morris-data.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/ressources/js/util.js"></script>
    <!-- blockUI - use as Modal Loading Content -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/ressources/js/blockUI.js"></script>

</body>

</html>
