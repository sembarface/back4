<?php
// Получаем данные из cookies
$errors = [];
$oldValues = [];
$savedValues = [];

if (isset($_COOKIE['form_errors'])) {
    $errors = json_decode($_COOKIE['form_errors'], true);
    $oldValues = json_decode($_COOKIE['old_values'], true);
}

// Получаем сохраненные значения
foreach ($_COOKIE as $name => $value) {
    if (strpos($name, 'saved_') === 0) {
        $field = substr($name, 6);
        $savedValues[$field] = $value;
    }
}

// Функция для получения значения поля
function getFieldValue($field, $default = '') {
    global $oldValues, $savedValues;
    
    if (isset($oldValues[$field])) {
        return $oldValues[$field];
    }
    
    if (isset($savedValues[$field])) {
        return $savedValues[$field];
    }
    
    return $default;
}

// Функция для проверки выбранного значения
function isSelected($field, $value) {
    global $oldValues, $savedValues;
    
    $currentValues = [];
    if (isset($oldValues[$field])) {
        if ($field === 'languages') {
            $currentValues = explode(',', $oldValues[$field]);
        } else {
            return $oldValues[$field] === $value ? 'checked' : '';
        }
    } elseif (isset($savedValues[$field])) {
        if ($field === 'languages') {
            $currentValues = explode(',', $savedValues[$field]);
        } else {
            return $savedValues[$field] === $value ? 'checked' : '';
        }
    }
    
    return in_array($value, $currentValues) ? 'selected' : '';
}

// Функция для проверки чекбокса
function isChecked($field) {
    global $oldValues, $savedValues;
    
    if (isset($oldValues[$field])) {
        return $oldValues[$field] ? 'checked' : '';
    }
    
    if (isset($savedValues[$field])) {
        return $savedValues[$field] ? 'checked' : '';
    }
    
    return '';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <link rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>САМЫЙ КРУТОЙ В МИРЕ САЙТ</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <style>
        .error-field {
            border: 1px solid #dc3545 !important;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
        .error-list {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }
        .success-message {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }
    </style>
</head>

<body class="d-flex flex-column align-items-center">
    <header class="container-fluid">
        <div class="row row-cols-1 row-cols-md-2 justify-content-center justify-content-md-between">
            <div class="header-case m-0 ms-md-1 col-md-auto d-flex align-items-center justify-content-center m-3">
                <img class="logo mx-3 m-mr-2" src="kotyara.jpg" alt="Котяра">
                <div class="nazvanie p-3">
                    <h3>САМЫЙ КРУТОЙ В МИРЕ САЙТ</h3>
                </div>
            </div>
            <nav class="menu mt-1 mt-md-0 p-2 col-auto d-flex flex-column flex-md-row align-items-center ">
                <div class="move mx-2"><a href ="#hiper">Список гиперссылок </a></div>
                <div class="move mx-2"><a href ="#tabl">Таблица </a></div>
                <div class="move mx-2"><a href ="#forma">Форма</a></div>
            </nav>
        </div>
    </header>
    <div class="content d-flex flex-column">
        <div class="hiper m-2 p-2 m-md-3" id="hiper">
            <ul>
                <li><a href="http://www.kubsu.ru/" title="Официальный сайт Кубанского государственного университета">КубГУ</a></li>
                <li><a href="https://www.kubsu.ru/" title="Официальный сайт Кубанского государственного университета">КубГУ https</a></li>
                <li><a href="https://en.wikipedia.org/wiki/Tim_Berners-Lee">
                    <img src="kotyara.jpg" alt="Котяра" height="100">
                </a></li>
                <li><a href="dva.html">ВНУТРЕННЯ ССЫЛКА</a></li>
                <li><a href="#important">Ссылка на важный фрагмент текущей страницы</a></li>
                <li><a href="dva.html?ip=12345&pp=54321&op=228">Ссылка с 3 параметрами url</a></li>
                <li><a href="dva.html?id=666">Ссылка с параметром id</a></li>
                <li><a href="./dva.html">Относительная ссылка на страницу в текущем каталоге</a></li>
                <li><a href="./about/tri.html">Страница в каталоге about</a></li>
                <li>
                    <p>
                        Да, <a href="https://en.wikipedia.org/wiki/Wolf">волк</a> слабее льва и тигра,
                        но в цирке <a href="https://en.wikipedia.org/wiki/Wolf">волк</a> не выступает
                    </p>
                </li>
                <li><a href="https://en.wikipedia.org/wiki/Capybara#Description">Физиологические параметры капибары</a></li>
                <li>
                    <span>Ссылки из прямоугольных и круглых областей</span><br>
                    <map name="map0">
                        <area shape="rect" alt="Прямоугольная область 1" coords="0,0,201,21" href="#area1">
                        <area shape="rect" alt="Прямоугольная область 2" coords="0,21,70,102" href="#area2">
                        <area shape="circle" alt="Круглая область" coords="90,50,45" href="#area3">
                        <area shape="rect" alt="Прямоугольная область 3" coords="0,0,201,102" href="#area4">
                    </map>
                    <img src="kotyara.jpg" width="201" height="102" usemap="#map0" alt="Котяра">
                </li>
                <li><a href="#">Ссылка с пустым href</a></li>
                <li><a href="#">Ссылка без href</a></li>
                <li><a href="https://www.kubsu.ru/" rel="nofollow">Запрещен переход поисковикам</a></li>
                <li><a href="https://www.kubsu.ru/" rel="noindex">Запрещенная для индексации поисковиками</a></li>
                <li>
                    <ol>
                        <li><a href="index.html" title="Первая">Первая</a></li>
                        <li><a href="index.html" title="Вторая">Вторая</a></li>
                        <li><a href="index.html" title="Третья">Третья</a></li>
                    </ol>
                </li>
                <li><a href="ftp://username:password@ftp.sobaka.com/path/to/file">Ссылка на файл на сервере FTP с авторизацией</a></li>
            </ul>
        </div>
        <div class="tabl m-2 p-2 m-md-3" id="tabl">
            <table>
                <caption>Значения тригонометрических функций</caption>
                <thead>
                    <tr>
                        <th>Функция</th>
                        <th>Значение (0)</th>
                        <th>Значение (π/6)</th>
                        <th>Значение (π/3)</th>
                        <th>Значение (π/2)</th>
                        <th>Значение (π)</th>
                        <th>Значение (3π/2)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>sin(x)</td>
                        <td>0</td>
                        <td>1/2</td>
                        <td>√3/2</td>
                        <td>1</td>
                        <td>0</td>
                        <td>-1</td>
                    </tr>
                    <tr>
                        <td>cos(x)</td>
                        <td>1</td>
                        <td>√3/2</td>
                        <td>1/2</td>
                        <td>0</td>
                        <td>-1</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>tan(x)</td>
                        <td>0</td>
                        <td>1/√3</td>
                        <td>√3</td>
                        <td>∞</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>cot(x)</td>
                        <td>∞</td>
                        <td>√3</td>
                        <td>1/√3</td>
                        <td>0</td>
                        <td>∞</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>csc(x)</td>
                        <td>∞</td>
                        <td>2</td>
                        <td>2/√3</td>
                        <td>1</td>
                        <td>∞</td>
                        <td>-1</td>
                    </tr>
                    <tr>
                        <td>sec(x)</td>
                        <td>1</td>
                        <td>2/√3</td>
                        <td>2</td>
                        <td>∞</td>
                        <td>-1</td>
                        <td>∞</td>
                    </tr>
                    <tr>
                        <td>----></td>
                        <td colspan="6">Вот такие пироги</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="forma m-2 p-2 m-md-3" id="forma">
            <h1>Форма</h1>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">Данные успешно сохранены!</div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="error-list">
                    <h3>Обнаружены ошибки:</h3>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form action="submit.php" method="POST">
                <!-- ФИО -->
                <label for="name">
                    ФИО:<br>
                    <input id="name" name="name" placeholder="Иванов Иван Иванович" required
                           value="<?php echo htmlspecialchars(getFieldValue('name')); ?>"
                           class="<?php echo isset($errors['name']) ? 'error-field' : ''; ?>">
                    <?php if (isset($errors['name'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['name']); ?></div>
                    <?php endif; ?>
                </label><br>
                
                <!-- Телефон -->
                <label for="phone">
                    Телефон:<br>
                    <input id="phone" type="tel" name="phone" placeholder="+7 (918) 123-45-67" required
                           value="<?php echo htmlspecialchars(getFieldValue('phone')); ?>"
                           class="<?php echo isset($errors['phone']) ? 'error-field' : ''; ?>">
                    <?php if (isset($errors['phone'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['phone']); ?></div>
                    <?php endif; ?>
                </label><br>
                
                <!-- Email -->
                <label for="email">
                    Электронная почта:<br>
                    <input id="email" name="email" type="email" placeholder="ogurec@example.com" required
                           value="<?php echo htmlspecialchars(getFieldValue('email')); ?>"
                           class="<?php echo isset($errors['email']) ? 'error-field' : ''; ?>">
                    <?php if (isset($errors['email'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['email']); ?></div>
                    <?php endif; ?>
                </label><br>
                
                <!-- Дата рождения -->
                <label for="birthdate">
                    Дата рождения:<br>
                    <input id="birthdate" name="birthdate" type="date" required
                           value="<?php echo htmlspecialchars(getFieldValue('birthdate')); ?>"
                           class="<?php echo isset($errors['birthdate']) ? 'error-field' : ''; ?>">
                    <?php if (isset($errors['birthdate'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['birthdate']); ?></div>
                    <?php endif; ?>
                </label><br>

                <!-- Пол -->
                <div>
                    Выберите пол:<br>
                    <label for="male">
                        <input id="male" type="radio" name="gender" value="male" required
                               <?php echo isSelected('gender', 'male'); ?>
                               class="<?php echo isset($errors['gender']) ? 'error-field' : ''; ?>"> Мужской
                    </label><br>
                    <label for="female">
                        <input id="female" type="radio" name="gender" value="female"
                               <?php echo isSelected('gender', 'female'); ?>
                               class="<?php echo isset($errors['gender']) ? 'error-field' : ''; ?>"> Женский
                    </label><br>
                    <label for="other">
                        <input id="other" type="radio" name="gender" value="other"
                               <?php echo isSelected('gender', 'other'); ?>
                               class="<?php echo isset($errors['gender']) ? 'error-field' : ''; ?>"> Другое
                    </label>
                    <?php if (isset($errors['gender'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['gender']); ?></div>
                    <?php endif; ?>
                </div><br>

                <!-- Языки программирования -->
                <label for="languages">
                    Любимый язык программирования:<br>
                    <select id="languages" name="languages[]" multiple="multiple" required
                            class="<?php echo isset($errors['languages']) ? 'error-field' : ''; ?>" size="5">
                        <?php 
                        $allLanguages = ['Pascal', 'C', 'C++', 'JavaScript', 'PHP', 'Python', 'Java', 'Haskell', 'Clojure', 'Prolog', 'Scala'];
                        foreach ($allLanguages as $lang): ?>
                            <option value="<?php echo htmlspecialchars($lang); ?>"
                                <?php echo isSelected('languages', $lang); ?>>
                                <?php echo htmlspecialchars($lang); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['languages'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['languages']); ?></div>
                    <?php endif; ?>
                </label><br>

                <!-- Биография -->
                <label for="bio">
                    Биография:<br>
                    <textarea id="bio" name="bio" placeholder="Ваша биография" required
                              class="<?php echo isset($errors['bio']) ? 'error-field' : ''; ?>"><?php 
                              echo htmlspecialchars(getFieldValue('bio')); ?></textarea>
                    <?php if (isset($errors['bio'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['bio']); ?></div>
                    <?php endif; ?>
                </label><br>

                <!-- Чекбокс контракта -->
                <label for="contract_accepted">
                    <input id="contract_accepted" type="checkbox" name="contract_accepted" value="1" required
                           <?php echo isChecked('contract_accepted'); ?>
                           class="<?php echo isset($errors['contract_accepted']) ? 'error-field' : ''; ?>">
                    С контрактом ознакомлен(а)
                    <?php if (isset($errors['contract_accepted'])): ?>
                        <div class="error-message"><?php echo htmlspecialchars($errors['contract_accepted']); ?></div>
                    <?php endif; ?>
                </label><br>

                <input type="submit" name="save" value="Сохранить" class="btn btn-primary">
            </form>
        </div>

        <h1 id="important">МЕНЯ ЗОВУТ ВОЛОДЯ</h1>
    </div>
    <footer class="page-footer p-3 mt-3">
        <span>© Владимир Хачатурян</span>
    </footer>
</body>
</html>
