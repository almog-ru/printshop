<?php
require_once 'core/init.php';
$user = new User();
if (!$user->isloggedIn()){
    Redirect::to('index.php');
}else{
    $data = $user->myorder();

}

?>
<style>
    body {
        margin: 0;
        min-width: 250px;
    }

    /* Include the padding and border in an element's total width and height */
    * {
        box-sizing: border-box;
    }

    /* Remove margins and padding from the list */
    ul {
        margin: 0;
        padding: 0;
    }

    /* Style the list items */
    ul li {
        cursor: pointer;
        position: relative;
        padding: 12px 8px 12px 40px;
        list-style-type: none;
        background: #eee;
        font-size: 18px;
        transition: 0.2s;

        /* make the list items unselectable */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Set all odd list items to a different color (zebra-stripes) */
    ul li:nth-child(odd) {
        background: #f9f9f9;
    }

    /* Darker background-color on hover */
    ul li:hover {
        background: #ddd;
    }

    /* When clicked on, add a background color and strike out text */
    ul li.checked {
        background: #888;
        color: #fff;
        text-decoration: line-through;
    }

    /* Add a "checked" mark when clicked on */
    ul li.checked::before {
        content: '';
        position: absolute;
        border-color: #fff;
        border-style: solid;
        border-width: 0 2px 2px 0;
        top: 10px;
        left: 16px;
        transform: rotate(45deg);
        height: 15px;
        width: 7px;
    }

    /* Style the close button */
    .close {
        position: absolute;
        right: 0;
        top: 0;
        padding: 12px 16px 12px 16px;
    }


    /* Clear floats after the header */
    .header:after {
        content: "";
        display: table;
        clear: both;
    }



</style>
<body>

<?php foreach($data as $order): ?>

<div id="myDIV" class="header">
    <h2> </h2>
</div>
    <ul id="myUL">
    <li>
        <?php echo $order->file_name;?>
    </li>

        <li>
        <?php echo $order->status;?>
    </li>

    <li>
        <?php echo $order->details;?>
    </li>

</ul>

    <?php endforeach; ?>

</body>