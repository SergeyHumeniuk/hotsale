<!DOCTYPE html>
<html>
<head>
    <title>Форма реєстрації</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Форма реєстрації</h1>
        <div id="success-message" class="alert alert-success" style="display: none;"></div>
        <div id="error-message" class="alert alert-danger" style="display: none;"></div>
        <form id="registration-form">
            <div class="form-group">
                <label for="name">Ім'я:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="surname">Прізвище:</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Повторіть пароль:</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Зареєструватися</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registration-form').submit(function(event) {
                event.preventDefault(); // Зупиняємо стандартну відправку форми

                var name = $('#name').val();
                var surname = $('#surname').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var confirmPassword = $('#confirm-password').val();

                // Виконуємо клієнтську валідацію
                if (!validateEmail(email)) {
                    displayErrorMessage('Введіть коректну адресу електронної пошти.');
                    return;
                }

                if (password !== confirmPassword) {
                    displayErrorMessage('Паролі не співпадають.');
                    return;
                }

                // AJAX запит на обробку даних на сервері
                $.ajax({
                    url: 'php/registration.php',
                    type: 'POST',
                    data: {
                        'name': name,
                        'surname': surname,
                        'email': email,
                        'password': password,
                        'confirmPassword': confirmPassword
                    },
                    success: function(response) {
                        if (response === 'success') {
                            displaySuccessMessage('Ви успішно зареєстровані!');
                            $('#registration-form').hide();
                        } else {
                            displayErrorMessage('Помилка при реєстрації.');
                        }
                    },
                    error: function() {
                        displayErrorMessage('Помилка при відправці AJAX запиту.');
                    }
                });
            });

            function validateEmail(email) {
                // Проста перевірка наявності символу @
                return email.indexOf('@') !== -1;
            }

            function displaySuccessMessage(message) {
                $('#success-message').text(message).show(); 
            }

            function displayErrorMessage(message) {
                $('#error-message').text(message).show();
            }
        });
    </script>
</body>
</html>
