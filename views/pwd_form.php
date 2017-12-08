<form action="pwdchange.php" method="post">
    <fieldset>
        <div class="form-group">
            <input class="form-control" name="old_password" placeholder="Old Password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="new_password" placeholder="New Password" type="password"/>
        </div>
          <div class="form-group">
            <input class="form-control" name="confirmation" placeholder="New Password Again" type="password"/>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
               Submit
            </button>
        </div>
    </fieldset>
</form>