<?php

    // configuration
    require("../includes/config.php");
    
     // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("quote_symbol.php", ["title" => "Get Quote"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $stock = lookup($_POST["symbol"]);
      
       if(!empty($stock))
       {
        $stock["price"]= number_format($stock["price"],2);
        render("quote_view.php",["title" => "Quote","symbol" => $stock["symbol"],"name" => $stock["name"],"price" => $stock["price"]]);
       }
       else
       {
           apologize("Symbol not found");
       }
    }
    
?>      