<div class="profile">
            <div class="image__container">
                <img src="<?php echo $user['avatar']?>" alt="" class="profile__image" onerror="this.onerror=null; this.src='images/default_pfp.jpg';">
            </div> 
            <div class="profile__info">
                <ul class="profile__info-list">
                    <li>
                        Имя:
                        <span id="nameText"><?php echo $user['name']; ?></span>
                        <button id="changeName">Изменить</button>
                    </li>
                    <li>
                        Логин:
                        <span id="loginText"><?php echo $user["login"]; ?></span>
                        <span id="inputName"></span>
                        <button id="changeLogin">Изменить</button>
                    </li>
                    
                    <li>
                        Пароль:
                        <span id="passwordText"> ******</span>
                        <button id="changePassword">Изменить</button>
                    </li>
                    <li>
                        Ссылка на аватарку:
                        <span id="imageText"><?php echo $user["avatar"]; ?></span>
                        <button id="changeImage">Изменить</button>
                    </li>
                </ul>
                <br><br>
                <button type="button" onclick="history.back()">Назад</button>
            </div>
        </div>