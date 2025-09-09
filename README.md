# Тестовое задание для Alef Development — Laravel API

Полная реализация API для управления студентами, классами и лекциями в соответствии с техническим заданием.

## Реализованные возможности

### Все 17 методов API

#### Студенты
1. `GET /students` — Получить список всех студентов  
2. `GET /students/{id}` — Получить данные конкретного студента (имя, email, класс, прослушанные лекции)  
3. `POST /students` — Создать нового студента  
4. `PUT /students/{id}` — Обновить данные студента (имя, класс)  
5. `DELETE /students/{id}` — Удалить студента  

#### Классы
6. `GET /school-classes` — Получить список всех классов  
7. `GET /school-classes/{id}` — Получить данные конкретного класса с его студентами  
8. `GET /school-classes/{id}/curriculum` — Получить учебный план (список лекций с порядком)  
9. `PUT /school-classes/{id}/curriculum` — Создать или обновить учебный план класса  
10. `POST /school-classes` — Создать новый класс  
11. `PUT /school-classes/{id}` — Обновить название класса  
12. `DELETE /school-classes/{id}` — Удалить класс (студенты остаются в системе, но открепляются от класса)  

#### Лекции
13. `GET /lectures` — Получить список всех лекций  
14. `GET /lectures/{id}` — Получить данные конкретной лекции (тема, описание, классы и студенты, которые её прошли)  
15. `POST /lectures` — Создать лекцию  
16. `PUT /lectures/{id}` — Обновить тему и описание лекции  
17. `DELETE /lectures/{id}` — Удалить лекцию  

---

### Технические требования

- **Строгая типизация** (`declare(strict_types=1)`)
- **Бизнес-логика вынесена в сервисы** (`StudentService`, `LectureService`, `SchoolClassService`)
- **Валидация вынесена в Form Request** (`StoreStudentRequest`, `UpdateStudentRequest` и т.д.)
- **Dependency Injection** — контроллеры не создают сервисы напрямую
- **Eager Loading** — оптимизированные запросы к БД
- **JSON-ответы** с корректными HTTP-кодами
- **Публичное API** — авторизация не требуется

---

## Как запустить проект

```bash
git clone https://github.com/Novoselov-Igor/alef_test_project.git
cd alef_test_project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
