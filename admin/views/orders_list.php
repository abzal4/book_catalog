<?php foreach($orders as $order): ?>
    <li class="list_order">
        <div class="list_left">
            <h4><a href="../order.php?id=<?= $order['id'] ?>" class="order_link">Заказ №<?= $order['id'] ?></a></h4>
            <p>Пользователь: <?= $order['user_name'] ?>(<?= $order['user_id'] ?>)</p>
            <p>Дата: <?= $order['created_at'] ?></p>
            <p style="display: flex;">
                Статус: <b><?= $order['status'] ?></b>&nbsp; 
                <select style='display: none;' name="status" class="selectStatus">
                    <option value="new">new</option>
                    <option value="processing">processing</option>
                    <option value="completed">completed</option>
                    <option value="cancelled">cancelled</option>
                </select>
                <button data-order-id='<?= $order['id'] ?>' class="btn-change_status">Изменить</button>
            </p>
            <p>Сумма: <?= $order['total_price'] ?></p>
        </div>
        <ol class="list_right">
            <h4>Товары</h4>
            <?php foreach($order['items'] as $book): ?>
                <li><?= $book['title'] ?>&nbsp;-&nbsp;<?= $book['quantity'] ?> шт.</li>
            <?php endforeach; ?>
        </ol>
    </li>
<?php endforeach; ?>