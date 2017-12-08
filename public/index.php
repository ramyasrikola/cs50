<?php

    // configuration
    require("../includes/config.php"); 
     
     if($_SERVER["REQUEST_METHOD"]=="GET")
     {
           
     
         $rows= CS50::query("SELECT * FROM portfolios WHERE user_id=?",$_SESSION["id"]);
         $cash = CS50::query("SELECT cash FROM users WHERE id=?",$_SESSION["id"]);
         $bal=$cash[0];
         $positions = [];
         foreach ($rows as $row)
           {
              $stock = lookup($row["symbol"]);
              if ($stock !== false)
              {
                  $positions[] = [
                   "name" => $stock["name"],
                   "price" => number_format($stock["price"],2),
                   "shares" => $row["shares"],
                   "symbol" => $row["symbol"],
                   "total" => number_format($row["shares"] * $stock["price"],2)
                   ];
              }
            }
           
            
            
         // render portfolio
         render("portfolio.php", ["amount" => number_format($bal["cash"],2), "positions" => $positions, "title" => "Portfolio"]);
           
     }      

?>
