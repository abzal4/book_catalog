<?php

function create_order($conn, $userId, $totalPrice, $status = 'new') {
    $sql = "insert into orders (user_id, total_price, status) values ($userId, $totalPrice, '$status')";
    if (mysqli_query($conn, $sql)) {
        return mysqli_insert_id($conn); 
    } 
    return false;
}

function create_order_item($conn, $orderId, $bookId, $price, $quantity) {
    $sql = "insert into order_items (order_id, book_id, price, quantity) values ($orderId, $bookId, $price, $quantity)";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        error_log(mysqli_error($conn));
        return false;
    }
    return true;
}

function get_order($conn, $orderId) {
    $sql_books = "select o.id as order_id, o.user_id , o.total_price , o.status , o.created_at, ib.id as book_id, ot.price, ot.quantity , ib.title   from  order_items ot 
                    left join imported_books ib on ot.book_id = ib.id
                    right  join orders o on ot.order_id = o.id where order_id = $orderId";
    $result = mysqli_query($conn, $sql_books);
    if (!$result) {
        error_log(mysqli_error($conn));
        return false;
    }
    $order = null;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($order == null) {
            $order = [
                'id' => $row['order_id'],
                'user_id' => $row['user_id'],
                'total_price' => $row['total_price'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'items' => []
            ];
        }

        $order['items'][] = [
            'book_id' => $row['book_id'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'title' => $row['title'],
        ];
    }
    return $order;
}

function get_user_orders($conn, $userId) {
    $sql_books = "select o.id as order_id, o.user_id , o.total_price , o.status , o.created_at, ib.id as book_id, ot.price, ot.quantity , ib.title   from  order_items ot 
                    left join imported_books ib on ot.book_id = ib.id
                    right  join orders o on ot.order_id = o.id where o.user_id = $userId";
    $result = mysqli_query($conn, $sql_books);
    if (!$result) {
        error_log(mysqli_error($conn));
        return false;
    }
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orderId = $row['order_id'];
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = [
                'id' => $row['order_id'],
                'user_id' => $row['user_id'],
                'total_price' => $row['total_price'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'items' => []
            ];
        }

        $orders[$orderId]['items'][] = [
            'book_id' => $row['book_id'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'title' => $row['title'],
        ];
    }
    return $orders;
}

function get_all_orders($conn) {
    $sql_books = "select o.id as order_id, o.user_id, u.name as user_name, o.total_price , o.status , o.created_at, ib.id as book_id, ot.price, ot.quantity , ib.title   from  order_items ot 
                    left join imported_books ib on ot.book_id = ib.id
                    right  join orders o on ot.order_id = o.id
                    left join users u on o.user_id = u.id";
    $result = mysqli_query($conn, $sql_books);
    if (!$result) {
        error_log(mysqli_error($conn));
        return false;
    }
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orderId = $row['order_id'];
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = [
                'id' => $row['order_id'],
                'user_id' => $row['user_id'],
                'user_name' => $row['user_name'],
                'total_price' => $row['total_price'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'items' => []
            ];
        }

        $orders[$orderId]['items'][] = [
            'book_id' => $row['book_id'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'title' => $row['title'],
        ];
    }
    return $orders;
}

function get_all_amount($conn) {
    $sql_books = "select count(*) as amount from orders";
    $result = mysqli_query($conn, $sql_books);
    if (!$result) {
        error_log(mysqli_error($conn));
        return false;
    }
    $ordersAmount = mysqli_fetch_assoc($result);
    return $ordersAmount;
}

function get_order_items_from_order($conn, $orderId) {
    $sql_books = "select book_id, quantity from order_items where order_id = $orderId";
    $result = mysqli_query($conn, $sql_books);
    if (!$result) {
        error_log(mysqli_error($conn));
        return false;
    }
    $order_items = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $order_items[] = $row;
    }
    return $order_items;
}

function update_status($conn, $orderId, $status) {
    $sql = "update orders set status = '$status' where id = $orderId";
    $result = mysqli_query($conn, $sql  );
    if (!$result) {
        error_log(mysqli_error($conn));
        return false;
    }
    return $result;
}
