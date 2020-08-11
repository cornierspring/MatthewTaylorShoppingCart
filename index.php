<html>

<head>
    <title>Shopping Cart</title>
</head>

<body>
    <?php
    // ######## please do not alter the following code ########  
    $products = [
        ["name" => "Sledgehammer", "price" => 125.75],
        ["name" => "Axe",          "price" => 190.50],
        ["name" => "Bandsaw",      "price" => 562.131],
        ["name" => "Chisel",       "price" =>  12.9],
        ["name" => "Hacksaw",      "price" =>  18.45],
    ];
    // ######################################################## 

    session_start();
    if (empty($_SESSION)) {
        $_SESSION["cart"] = array();
    }

    /* The following functions have been written to help improve the understanability 
    of the code */

    function displayProducts($products)
    {
        foreach ($products as $product) {
            echo $product["name"] . ": $" . number_format((float)$product["price"], 2, '.', "") . " ";
            echo "<a href=\"index.php?name=" . $product["name"] . "\">Add to cart</a>";
            echo "<p>--------------------------------------------</p>";
        }
    }

    /**@param $talliedContent - an array of shopping cart items formatted and tallied */
    function displayCart($talliedContent)
    {

        $runningTotal = 0;
        foreach ($talliedContent as $individualContent) {

            $total = ((float) $individualContent["price"] * $individualContent["quantity"]);
            echo $individualContent["name"] . " x" . $individualContent["quantity"] . ": $" . number_format((float)$total, 2, '.', "") . " ";
            echo "<a href=\"index.php?name=" . $individualContent["name"] . "&remove=true" . "\">Remove from cart</a>";
            echo "<p>--------------------------------------------</p>";
            $runningTotal = $runningTotal + $total;
        }

        echo "<p> Total: $" . number_format((float)$runningTotal, 2, '.', "") . "</p>";
        echo "<a href=\"index.php\">Hide cart content(s)</a>";
    }

    function addItemToCart()
    {
        array_push($_SESSION["cart"], $_GET["name"]);
        echo $_GET["name"] . " has been added to your cart.";
    }

    /* Removes just one of specified item from shopping cart */
    function removeItemFromCart()
    {
        foreach ($_SESSION["cart"] as $itemKey => $currentItem) {
            if (strcmp($currentItem, $_GET["name"]) == 0) {
                unset($_SESSION["cart"][$itemKey]);
                break;
            }
        }
        echo "A " . $_GET["name"] . " has been removed from your cart.";
    }

    /** Counts the number of each item in the shopping cart as well as calculates total cost for
     * that item. 
     */
    function tallyContent($products)
    {
        $talliedContent = array();
        foreach ($products as $product) {

            $count = 0;
            foreach ($_SESSION["cart"] as $currentItem) {

                if (strcmp($currentItem, $product["name"]) == 0) {
                    $count++;
                }
            }

            if ($count > 0) {

                $productQuantity = [
                    "name" => $product["name"],
                    "price" => $product["price"],
                    "quantity" => $count
                ];
                array_push($talliedContent, $productQuantity);
            }
        }
        return $talliedContent;
    }

    function isAddingItem()
    {
        if (isset($_GET["name"]) && !isset($_GET["remove"])) {
            return true;
        } else {
            return false;
        }
    }

    function isRemovingItem()
    {
        if (isset($_GET["name"]) && isset($_GET["remove"])) {
            return true;
        } else {
            return false;
        }
    }

    function isShowCart()
    {
        if (isset($_GET["showCart"])) {
            return true;
        } else {
            return false;
        }
    }

    function lineSeparatorMajor()
    {
        echo "<p>=================================================</p>";
    }

    /* the flow of the program starts here */

    echo "<p>=================================================</p>";

    displayProducts($products);

    echo "<p>=================================================</p>";

    if (isAddingItem()) {
        addItemToCart();
    }

    if (isRemovingItem()) {
        removeItemFromCart();
    }

    if (isShowCart()) {

        $talliedContent = tallyContent($products);
        displayCart($talliedContent);
    } else {

        echo "<a href=\"index.php?showCart=true\">Show cart content(s)</a>";
    }

    echo "<p>=================================================</p>";

    ?>

</body>

</html>