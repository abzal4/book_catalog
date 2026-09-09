<?php

require_once __DIR__ .'/../functions/books.php';
require_once __DIR__ .'/../functions/orders.php';
require_once __DIR__ .'/../validators/IdValidator.php';

class OrderController {
    public static function createOrder ($conn, $userId) {
        $userId = IdValidator::validateId($userId);
        if (!$userId) {
            return [
                'success' => false,
                'message' => 'Неправильный ID!'
            ];
        }
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            return [
                'success' => false,
                'message' => 'Корзина пуста!'
            ];
        }
        $cart = $_SESSION['cart'];
        $book_price = 750;
        $total_price = 0;

        foreach($cart as $bookId => $quantity) {
            $checkStock = BookController::checkStock($conn, $bookId, $quantity);
            if (!$checkStock['success']) {
                return [
                    'success' => false,
                    'message' => $checkStock['message'],
                ];
            }
            $total_price += $book_price * $quantity;
        }

        mysqli_begin_transaction($conn);
        try {
            $orderId = create_order($conn, $userId, $total_price);
            if (!$orderId) {
                throw new Exception('Не удалось создать заказ');
            }

            foreach($cart as $bookId => $quantity) {
                $result = create_order_item($conn, $orderId, $bookId, $book_price, $quantity);
                if (!$result) {
                    throw new Exception ('Не удалось добавить товар в заказ');
                }
                if (!update_stock($conn, $bookId, -$quantity)){
                    throw new Exception ('Не удалось обновить склад');
                }
            }
            
            mysqli_commit($conn);
            $_SESSION['cart'] = [];
            return [
                'success' => true,
                'orderId' => $orderId
            ];
        } catch (Exception $e) {
            mysqli_rollback($conn);
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function getUserOrders ($conn, $userId) {
        $userId = IdValidator::validateId($userId);
        if (!$userId) {
            return [
                'success' => false,
                'message' => 'Неправильный ID!'
            ];
        }
        $orders = get_user_orders($conn , $userId);
        if (!$orders) {
            return [
                'success' => false,
                'message' => 'Не получилось получить заказы'
            ];
        }
        return [
            'success' => true,
            'data' => $orders
        ];
    }

    public static function getOrder ($conn, $orderId, $userId, $role) {
        $userId = IdValidator::validateId($userId);
        $orderId = IdValidator::validateId($orderId);
        if (!$orderId || !$userId) {
            return [
                'success' => false,
                'message' => 'Неправильный ID!'
            ];
        }
        $order = get_order($conn , $orderId);
        if (!$order) {
            return [
                'success' => false,
                'message' => 'Не получилось получить заказ'
            ];
        }
        if ($role != 'admin') {
            if ((int)$order['user_id'] != (int)$userId) {
                return [
                    'success' => false,
                    'message' => 'Не ваш заказ!'
                ];
            }
        }
        return [
            'success' => true,
            'data' => $order
        ];
    }

    public static function getAllOrders ($conn) {
        $orders = get_all_orders($conn);
        if (!$orders) {
            return [
                'success' => false,
                'message' => 'Не получилось получить заказы'
            ];
        }
        return [
            'success' => true,
            'data' => $orders
        ];
    }

    public static function getAllAmount ($conn) {
        $ordersAmount = get_all_amount($conn);
        if (!is_array($ordersAmount)) {
            return [
                'success' => false,
                'message' => 'Не получилось получить заказы'
            ];
        }
        return [
            'success' => true,
            'data' => $ordersAmount
        ];
    }

    public static function updateStatus ($conn, $orderId, $status) {
        
        $orderId = IdValidator::validateId($orderId);

        mysqli_begin_transaction($conn);
        try {
            
            $order = get_order($conn, $orderId);
            if (!$order) {
                throw new Exception('Заказ не найден.');
            }
            if ($order['status'] !== 'new') {
                throw new Exception('Статус этого заказа уже нельзя изменить.');
            }
            if ($status == 'cancelled') {
                $order_items = get_order_items_from_order($conn, $orderId);
                foreach ($order_items as $order_item) {
                    update_stock($conn, $order_item['book_id'], $order_item['quantity']);
                }
            }
            $result = update_status($conn, $orderId, $status);
            if (!$result) {
                throw new Exception('Не получилось изменить статус заказа.');
            }
            
            mysqli_commit($conn);
            return [
                'success' => true
            ];
        } catch (Exception $e) {
            mysqli_rollback($conn);
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}