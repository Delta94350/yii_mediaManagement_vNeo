<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Connexion <small>Medias management plateform</small>
        </h1>
        <form class="form-horizontal" method="POST" action="/index.php/user/login" role="form">
            <div class="form-group">
                <label for="inputLogin" class="col-sm-2 control-label">Login : </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="inputLogin" id="inputLogin" placeholder="Your login" onchange="checkLoginField()" required>
                    <span id="hasLogin"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Password : </label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Your secret password" required>
                </div>
            </div>
            <input id="loginButton" type="submit" class="btn btn-success" value="Connexion"/>
        </form>
    </div>
</div>
<!-- /.row -->