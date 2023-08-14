[![author-check](https://github.com/Marre-86/test-medic/actions/workflows/author-check.yml/badge.svg)](https://github.com/Marre-86/test-medic/actions/workflows/author-check.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/04cf62d616af0bd7d140/maintainability)](https://codeclimate.com/github/Marre-86/test-medic/maintainability)

## About

Данное веб-приложение было выполнено [Артёмом Похилюком](https://www.linkedin.com/in/artem-pokhiliuk/) в качестве тестового задания. Сделано полностью во фреймворке Laravel.

Задание, в соответствии с которым был выполнен проект, можно найти [здесь](https://docs.google.com/document/d/1Odscti-TbxImlQo6qSe1UCfwenEk2u10ZmuXffOEkuQ/edit).

Проект задеплоен на платформу **Railway** и доступен [по этой ссылке](https://test-articles-pokhiliuk.up.railway.app). Чтобы увидеть начинку сайта - админ-панель, нужно залогиниться под email **a@a**, пароль **a**.
 
Описание эндпойнтов API:

**server url** - https://test-articles-pokhiliuk.up.railway.app/api:

- **GET /articles** - возвращает все статьи. Доступны параметры ***page*** и ***per_page***.
- **GET /categories** - возвращает все категории. 
- **GET /articles/category/:id** - возвращает все статьи из указанной категории.
- **GET /articles/slug/:slug** - возвращает статью по указанному slug.
