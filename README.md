# Тестовое задание PHP Developer для Perfect Panel

## Задание №1

```sql
SELECT
    u.id AS ID,
    CONCAT(u.first_name, " ", u.last_name) AS Name,
    b.author AS Author,
    GROUP_CONCAT(b.name SEPARATOR ", ") AS Books
FROM users AS u
JOIN user_books AS ub ON ub.user_id = u.id
JOIN books AS b ON b.id = ub.book_id
WHERE u.age BETWEEN 7 AND 17
GROUP BY u.id
HAVING COUNT(b.id) = 2
    AND COUNT(DISTINCT b.author) = 1
```

## Задание №2

    Задачу решил с использованием Yii2.

    Для простоты развёртывания теста не исползую БД.

    В качестве хранилища токенов авторизации используется статическая модель User

    Комиссия и урл сервиса курсов настраиваются в константах модели Currency

### Файлы

    Dockerfile - PHP8-fpm образ с установленным внутри композером

    docker-compose.yml - содержит 2 сервиса nginx и php-fpm

    dev.conf - настройки nginx

    build-image.sh - сборка образов

    run.sh - сборка контейнеров

    chmod-runtime.sh - разрешить запись в папку runtime



### Сборка

Для сборки нужны локально установленные git, docker, docker-compose

1. клонирование репозитория

    переходим в выбранную директорию, затем:
```bash
git clone git@github.com:good-dev/test_for_perfect_panel.git .
```

2. Настраиваем.

копируем `.env.example` в `.env`

в `.env`:

    - PORT_ON_LOCALHOST - настройте порт на localhost, на котором будет работать сервис.

Если не занят - можно оставить как есть 

3. далее, для сборки образов надо запустить `build-image.sh`

4. после успешной сборки запустите контейнеры с помощю `run.sh`

5. затем соберите проект запустив `exec-composer-install.sh`

6. разрешите запись в папку runtime запустив `chmod-runtime.sh`

После этих действий сервис должен быть доступен по адресу http://localhost:8082/api/v1

Если изменяли порт в PORT_ON_LOCALHOST используйте его

### Тестирование

Для удобства тестирования создал страницу http://localhost:8082

чтобы остановить контейнеры - запустите `stop.sh`