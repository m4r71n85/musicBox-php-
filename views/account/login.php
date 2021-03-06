<div class="row">
    <div class="modal-content col-sm-6">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Log in</h4>
        </div> 
            <form role="form"  action="/account/login" method="Post" >

        <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" id="uLogin" placeholder="Login" name="username">
                        <label for="uLogin" class="input-group-addon glyphicon glyphicon-user"></label>
                    </div>
                </div> <!-- /.form-group -->

                <div class="form-group">
                    <div class="input-group">
                        <input type="password" class="form-control" id="uPassword" placeholder="Password" name="password">
                        <label for="uPassword" class="input-group-addon glyphicon glyphicon-lock"></label>
                    </div> <!-- /.input-group -->
                </div> <!-- /.form-group -->
                
    <a href="/account/register" class="pull-right">Go to register</a>
        </div> <!-- /.modal-body -->

        <div class="modal-footer">
            <button class="form-control btn btn-primary" type="submit">Login</button>
        </div> <!-- /.modal-footer -->
            </form>

    </div><!-- /.modal-content -->
</div>