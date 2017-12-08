<?php

    // configuration
    require("../includes/config.php"); 
     if($_SERVER["REQUEST_METHOD"]=="GET")
     {
         $positions = [];
         $rows = CS50::query("SELECT * FROM history WHERE user_id=?",$_SESSION["id"]);
         foreach ($rows as $row)
           {
               $positions[]=[
                   "transaction" => $row["transaction"],
                   "time" => $row["time"],
                   "symbol" => $row["symbol"],
                   "shares" => $row["shares"],
                   "price" => number_format($row["price"],2)
                   ];
           }
        render("history_view.php",["title" => "Portfolio", "positions" => $positions]);    
     }
?>         