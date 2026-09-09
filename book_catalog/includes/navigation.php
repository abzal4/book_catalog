

<header class="header">
    <div class="header__container">
        <a class="home" href="/../index.php">  Home </a> 
        <a class="login" href="/../login.php"> Вход </a>
        <div class="user_menu" style="display: none;">
            <a class="profile" href="/../profile.php">
                <img class="profile_image" src="/../images/default_pfp.jpg" alt="Аватар"> 
                <div class="profile__name"></div> 
            </a> 
            <a class="favorites" href="/../favorites_books.php"> Избранные </a> 
            <a class="cart" href="/../cart.php"> Корзина </a> 
            <a class="cart" href="/../orders.php"> Мои заказы </a> 
            <a class="admin" href="/../admin/admin.php" style="display: none;" > Админка </a>
            <a class="logout" href="/../logout.php"> Выйти из аккаунта  </a>
        </div>
    </div>
</header>

<script>
    const container = document.querySelector(".header__container");
    const login = document.querySelector(".login");
    const userMenu = document.querySelector(".user_menu");
    const profile = document.querySelector(".profile");
    const avatar = document.querySelector(".profile_image");
    const name = document.querySelector(".profile__name");
    const admin = document.querySelector(".admin");

    async function getUser() {
        try {
            const response = await fetch("/../ajax/user_back.php?action=getUser");
            const data = await response.json();
            if (!response.ok || !data.success) {
                login.style.display = "block";
                userMenu.style.display = "none";
                return;
            }

            const user = data.data;
            login.style.display = "none";
            userMenu.style.display = "flex";
            name.textContent = user.name;
            avatar.src = user.avatar;

            avatar.onerror = function () {
                this.onerror = null;
                this.src = "/../images/default_pfp.jpg";
            };

            if (user.role === "admin") {
                admin.style.display = "block";
            } else {
                admin.style.display = "none";
            }

        } catch (error) {
            console.error("Ошибка загрузки пользователя:", error);
            login.style.display = "block";
            userMenu.style.display = "none";
        }
    }

    getUser();
</script>