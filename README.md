# test_for_perfect_panel
API for currency exchange

Тестовое задание PHP Developer для Perfect Panel

Решение Задания №1

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

Задание №2