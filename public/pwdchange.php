<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("pwd_form.php", ["title" => "Password Change"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
         $rows = CS50::query("SELECT * FROM users WHERE id = ?",$_SESSION["id"]);
       
         $row = $rows[0];

            // compare hash of user's input against hash that's in database
            if (!(password_verify($_POST["old_password"], $row["hash"])))
            {
                apologize("Old password does not match.Please try again");
            }    
            if ($_POST["new_password"]!= $_POST["confirmation"])
            {
                apologize("your new password and confirmation password do not match.Please try again.");
            }
            else
            {
                $pwd=password_hash($_POST["new_password"], PASSWORD_DEFAULT);
               
             $hash=CS50::query("UPDATE users SET hash=? WHERE  id=?",$pwd,$_SESSION["id"]);
             
            // redirect to portfolio
                redirect("/");
            }
    }

?>