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
        return htmlspecialchars($oldValues[$field]);
    }
    
    if (isset($savedValues[$field])) {
        return htmlspecialchars($savedValues[$field]);
    }
    
    return $default;
}

// Функция для проверки выбранного значения
function isSelected($field, $value) {
    global $oldValues, $savedValues;
    
    if (isset($oldValues[$field])) {
        if ($field === 'languages') {
            return in_array($value, explode(',', $oldValues[$field])) ? 'selected' : '';
        }
        return $oldValues[$field] === $value ? 'checked' : '';
    }
    
    if (isset($savedValues[$field])) {
        if ($field === 'languages') {
            return in_array($value, explode(',', $savedValues[$field])) ? 'selected' : '';
        }
        return $savedValues[$field] === $value ? 'checked' : '';
    }
    
    return '';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Ваши мета-теги и стили -->
    <style>
        .error { color: red; }
        .error-field { border: 1px solid red; }
    </style>
</head>
<body>
    <div class="forma m-2 p-2 m-md-3" id="forma">
        <h1>Форма</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Данные успешно сохранены!</div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
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
                       value="<?php echo getFieldValue('name'); ?>"
                       class="<?php echo isset($errors['name']) ? 'error-field' : ''; ?>">
                <?php if (isset($errors['name'])): ?>
                    <span class="error"><?php echo htmlspecialchars($errors['name']); ?></span>
                <?php endif; ?>
            </label><br>
            
            <!-- Телефон -->
            <label for="phone">
                Телефон:<br>
                <input id="phone" type="tel" name="phone" placeholder="+7 (918) 123-45-67" required
                       value="<?php echo getFieldValue('phone'); ?>"
                       class="<?php echo isset($errors['phone']) ? 'error-field' : ''; ?>">
                <?php if (isset($errors['phone'])): ?>
                    <span class="error"><?php echo htmlspecialchars($errors['phone']); ?></span>
                <?php endif; ?>
            </label><br>
            
            <!-- Остальные поля формы с аналогичной структурой -->
            <!-- Добавьте все остальные поля формы аналогичным образом -->
            
            <input type="submit" name="save" value="Сохранить">
        </form>
    </div>
</body>
</html>
