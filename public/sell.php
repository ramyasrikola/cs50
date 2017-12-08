<?php

    // configuration
    require("../includes/config.php"); 
     
     if($_SERVER["REQUEST_METHOD"]=="GET")
     {  
        
         $list = [];
         $rows= CS50::query("SELECT * FROM portfolios WHERE user_id=?",$_SESSION["id"]);
         if(empty($rows))
         {
             apologize("Nothing to Sell");
         }
         else
         {  
             foreach($rows as $row)
             {
                $list[]=$row["symbol"];
             }
             
             // render portfolio
         render("sell_form.php", ["title" => "Sell","lists" => $list]); 
         }
     } 
     else if($_SERVER["REQUEST_METHOD"]=="POST")
     {
        $x = CS50::query("SELECT shares FROM portfolios WHERE user_id = ? AND symbol = ? ",$_SESSION["id"],$_POST["symbol"]);
       
        $y=$x[0];
        $transaction='SELL';
        $price1=lookup($_POST["symbol"]);
        $price=$price1["price"];
        $amt=$y["shares"]*$price;
        CS50::query("UPDATE users SET cash = cash + $amt WHERE id = ?",$_SESSION["id"]);
        CS50::query("DELETE FROM portfolios WHERE user_id = ? AND symbol = ? ",$_SESSION["id"],$_POST["symbol"]);
      
        CS50::query("INSERT INTO history (user_id,transaction,time,symbol,shares,price) VALUES(?,?,CURRENT_TIMESTAMP,?,?,?)",$_SESSION["id"],$transaction,$_POST["symbol"],$y["shares"],$price);
        $rows_new= CS50::query("SELECT * FROM portfolios WHERE user_id=?",$_SESSION["id"]);
       
        $positions = [];
         foreach ($rows_new as $row_new)
           {
               $stock = lookup($row_new["symbol"]);
              if ($stock !== false)
              {
                  $positions[] = [
                   "name" => $stock["name"],
                   "price" => number_format($stock["price"],2),
                   "shares" => $row_new["shares"],
                   "symbol" => $row_new["symbol"],
                   "total" => number_format($row_new["shares"] * $stock["price"],2)
                   ];
              }
            }
            $amount1=CS50::query("SELECT cash FROM users WHERE id = ?",$_SESSION["id"]);
            $amount=$amount1[0];
            render("portfolio.php", ["amount" => number_format($amount["cash"],2), "positions" => $positions, "title" => "Portfolio"]);
     }
     ?>