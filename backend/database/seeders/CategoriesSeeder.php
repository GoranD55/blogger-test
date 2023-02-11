<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Psr\SimpleCache\InvalidArgumentException;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        try {
            cache()->delete('categories');
        } catch (InvalidArgumentException) {}

        $categories = [
            ['name' => 'Новости'],
            ['name' => 'Автомобили'],
            ['name' => 'Мотоциклы'],
            ['name' => 'Самолеты'],
            ['name' => 'Велосипеды'],
            ['name' => 'Хобби'],
            ['name' => 'Компьютерные игры'],
            ['name' => 'Новинки'],
            ['name' => 'Мода'],
            ['name' => 'Здоровье'],
            ['name' => 'Красота'],
            ['name' => 'Путешествия'],
            ['name' => 'Наука'],
            ['name' => 'BMW'],
            ['name' => 'Mercedes-Benz'],
            ['name' => 'Volkswagen'],
            ['name' => 'Audi'],
            ['name' => 'Porsche'],
            ['name' => 'Toyota'],
            ['name' => 'Nissan'],
            ['name' => 'Honda'],
            ['name' => 'Lada'],
            ['name' => 'Skoda'],
            ['name' => 'Dodge'],
            ['name' => 'Chevrolet'],
            ['name' => 'Ford'],
            ['name' => 'Tesla'],
            ['name' => 'Косметика'],
            ['name' => 'Кухонные принадлежности'],
            ['name' => 'Мебель'],
            ['name' => 'Еда'],
            ['name' => 'Картины'],
            ['name' => 'Ноутбуки'],
            ['name' => 'Macbook'],
            ['name' => 'Lenovo'],
            ['name' => 'Samsung'],
            ['name' => 'Средства ухода'],
            ['name' => 'Витамины'],
            ['name' => 'Биологически Активные Добавки (БАД)'],
            ['name' => 'Спортивное питание'],
            ['name' => 'Спорт'],
            ['name' => 'Еда быстрого приготовления'],
            ['name' => 'Рецепты'],
            ['name' => 'Инструмент'],
            ['name' => 'Bosch'],
            ['name' => 'Спортивный инвернтарь'],
            ['name' => 'Обувь'],
            ['name' => 'Кроссовки'],
            ['name' => 'Туфли'],
            ['name' => 'Отдых'],
            ['name' => 'Активный отдых'],
            ['name' => 'Серфинг'],
            ['name' => 'Баскетбол'],
            ['name' => 'Футбол'],
        ];

        Category::query()->truncate();
        Category::query()->insert($categories);
    }
}
