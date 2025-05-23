# 🗃️ Проект: Учёт заработной платы рабочих

## 📌 Задание

1. **Спроектировать реляционную базу данных** согласно варианту задания (описан ниже).
2. **Реализовать RESTful API** для backend-части приложения. При реализации необходимо соблюдать принципы REST API:  
   [https://habr.com/ru/post/447322/](https://habr.com/ru/post/447322/)

   Для каждой сущности реализовать стандартный набор методов (CRUD):
   - `GET` — получение списка сущностей
   - `GET /{id}` — получение одной сущности по уникальному идентификатору
   - `POST` — создание новой сущности
   - `PUT /{id}` — редактирование сущности
   - `DELETE /{id}` — удаление сущности

3. Использовать соответствующие фреймворки для реализации REST API:
   - [FastAPI](https://fastapi.tiangolo.com/ru/) — для Python
   - [JHipster](https://www.jhipster.tech/) — для Java
   - [Laravel](https://laravel.com/) — для PHP
   - [Entity Framework](https://www.learnentityframeworkcore.com/) — для ASP.NET

4. **Произвести первичное наполнение БД** данными, согласно заданию.
5. Для тестирования API использовать:
   - [Postman](https://www.postman.com/)
   - [Swagger](https://swagger.io/)
6. **Покрыть тестами все сущности** и все реализованные методы.

---

## 📥 Дополнительные требования

- Для каждой сущности должна быть реализована:
  - Сортировка
  - Пагинация
  - Фильтрация
- Валидация входящих запросов с генерацией корректных ошибок согласно REST-спецификации.
- Реализация **JWT-авторизации** пользователя в системе.

---

## 🧱 Структура базы данных

База данных должна содержать следующие сущности:

### 📘 Тип продукции
> Справочник, содержащий наименование типа производимой продукции.

### 🔩 Детали
> Справочник, содержащий:
- Наименование детали
- Вес
- Материал
- Тип продукции *(внешний ключ на "Тип продукции")*

### 🏭 Цех
> Содержит:
- Наименование цеха
- ФИО начальника цеха
- Фотография начальника

### 👷 Рабочий
> Содержит:
- ФИО рабочего
- Принадлежность к цеху *(внешний ключ)*
- Разряд
- Размер текущей заработной платы
- История зарплат за прошедший год *(можно реализовать отдельной сущностью `SalaryHistory`)*

---

## 📦 Пример API

```http
GET /api/employees
GET /api/employees/{id}
POST /api/employees
PUT /api/employees/{id}
DELETE /api/employees/{id}
```

# 🧱 Структура базы данных

База данных включает несколько ключевых сущностей, каждая из которых отвечает за определённый аспект системы. Ниже представлены описания сущностей, их поля и назначение.

---

## 📘 Тип продукции (`ProductType`)

> Справочник, содержащий информацию о типах производимой продукции.

| Поле       | Тип       | Описание                          |
|------------|-----------|-----------------------------------|
| `id`       | integer   | Уникальный идентификатор (PK)     |
| `name`     | string    | Название продукции                |

---

## 🏭 Фабрика / Цех (`Workshop`)

> Справочник, содержащий информацию о фабриках и начальниках цехов.

| Поле            | Тип     | Описание                              |
|-----------------|---------|---------------------------------------|
| `id`            | integer | Уникальный идентификатор (PK)         |
| `title`         | string  | Название фабрики                      |
| `chief_name`    | string  | Имя начальника цеха                   |
| `chief_surname` | string  | Фамилия начальника цеха               |

---

## 🔩 Детали (`Detail`)

> Справочник деталей, связанных с типами продукции.

| Поле        | Тип     | Описание                                                    |
|-------------|---------|-------------------------------------------------------------|
| `id`        | integer | Уникальный идентификатор (PK)                               |
| `title`     | string  | Название детали                                             |
| `weight`    | float   | Вес детали                                                  |
| `material`  | string  | Материал                                                    |
| `product_id`| integer | Внешний ключ на `ProductType` (тип продукции)               |

---

## 👷 Сотрудники (`Employee`)

> Таблица, содержащая информацию о рабочих.

| Поле         | Тип     | Описание                                        |
|--------------|---------|-------------------------------------------------|
| `id`         | integer | Уникальный идентификатор (PK)                   |
| `name`       | string  | Имя сотрудника                                  |
| `surname`    | string  | Фамилия сотрудника                              |
| `rank`       | integer | Разряд сотрудника                               |
| `salary`     | integer | Текущий размер заработной платы                 |
| `workshop_id`| integer | Внешний ключ на `Workshop` (принадлежность цеху)|

---

## 💰 История зарплат (`SalaryHistory`)

> Хранит записи об изменениях зарплаты сотрудников.

| Поле         | Тип     | Описание                                        |
|--------------|---------|-------------------------------------------------|
| `id`         | integer | Уникальный идентификатор (PK)                   |
| `amount`     | integer | Размер зарплаты                                 |
| `date`       | date    | Дата выплаты                                    |
| `employee_id`| integer | Внешний ключ на `Employee`                      |

---

## 🔄 Нормализация данных

База данных приведена к **третьей нормальной форме (3NF)**:

- Каждая сущность имеет уникальный **первичный ключ**.
- Все атрибуты зависят **только от первичного ключа**.
- Отсутствуют **транзитивные зависимости**.

✅ Это позволяет исключить избыточность данных и гарантировать их целостность.

---

# 🌐 Реализация RESTful API

На втором этапе был разработан API, соответствующий принципам **REST**, обеспечивающий полный доступ к данным через стандартизированный интерфейс.

## 🔗 Эндпоинты CRUD

Пример для сущности `Workshop`:

### Получение списка

```http
GET /api/workshops/

