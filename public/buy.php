<?php

    // configuration
    require("../includes/config.php"); 
     
     if($_SERVER["REQUEST_METHOD"]=="GET")
     {  
         render("buy_form.php", ["title" => "Buy"]);
     }
     else if($_SERVER["REQUEST_METHOD"]=="POST")
     {
         if(empty($_POST["symbol"]))
         {
             apologize("You must enter a stock symbol to buy!");
         }
         if(empty($_POST["shares"])|| !(preg_match("/^\d+$/", $_POST["shares"])))
         {
             apologize("You must specify the number of shares!");
         }
         $stock = lookup($_POST["symbol"]);
         if(empty($stock))
         {
             apologize("You must specify a valid stock symbol to buy!");
         }
         else
         {
             $cash= CS50::query("SElECT cash FROM users WHERE id=?",$_SESSION["id"]);
             $cash1=$cash[0];
             $total=$_POST["shares"] * $stock["price"];
             if($total> $cash1["cash"])
             {
                 apologize("You cant afford that.");
             }
             $transaction='BUY';
             $buy=CS50::query("INSERT INTO portfolios (user_id, symbol, shares) VALUES(?,?,?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)",$_SESSION["id"],strtoupper($_POST["symbol"]),$_POST["shares"]);
             
             $history = CS50::query("INSERT INTO history (user_id,transaction,time,symbol,shares,price) VALUES(?,?,CURRENT_TIMESTAMP,?,?,?)",$_SESSION["id"],$transaction,strtoupper($_POST["symbol"]),$_POST["shares"],$stock["price"]);
             
             if($buy!=0)
              {
                 CS50::query("UPDATE users SET cash = cash - $total WHERE id = ?",$_SESSION["id"]);
                 $rows=CS50::query("SELECT * FROM portfolios WHERE user_id=?",$_SESSION["id"]);
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
                 $amount1=CS50::query("SELECT cash FROM users WHERE id = ?",$_SESSION["id"]);
            $amount=$amount1[0];
            render("portfolio.php", ["amount" => number_format($amount["cash"],2), "positions" => $positions, "title" => "Portfolio"]);
             }
         }
     }
?>     