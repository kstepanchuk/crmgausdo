<?php

namespace Database\Seeders;

use App\Enums\RequestStatus;
use App\Models\Camp;
use App\Models\ProcurementRequest;
use App\Models\RequestItem;
use App\Models\RequestTemplate;
use App\Models\RequestTemplateItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $camp = Camp::query()->firstOrCreate(['name' => 'Main Camp'], [
            'location' => 'Default location',
        ]);

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'camp_id' => $camp->id,
            ]
        );

        $template = RequestTemplate::query()->firstOrCreate(['name' => 'Стартовый шаблон'], [
            'description' => 'Базовый шаблон заявки',
        ]);

        $templateItems = [
            ['item_name' => 'Ноутбук', 'quantity' => 1, 'unit_price' => 80000, 'position' => 1],
            ['item_name' => 'Мышь', 'quantity' => 1, 'unit_price' => 1500, 'position' => 2],
        ];

        foreach ($templateItems as $item) {
            RequestTemplateItem::query()->firstOrCreate(
                ['request_template_id' => $template->id, 'item_name' => $item['item_name']],
                $item
            );
        }

        $request = ProcurementRequest::query()->firstOrCreate(
            ['title' => 'Пример заявки'],
            [
                'requested_by' => 'Инициатор',
                'status' => RequestStatus::Submitted,
                'camp_id' => $camp->id,
                'user_id' => $admin->id,
                'request_template_id' => $template->id,
                'notes' => 'Заготовка заявки для демонстрации',
            ]
        );

        $items = [
            ['item_name' => 'Ноутбук', 'quantity' => 2, 'unit_price' => 80000, 'position' => 1],
            ['item_name' => 'Мышь', 'quantity' => 2, 'unit_price' => 1500, 'position' => 2],
        ];

        foreach ($items as $item) {
            RequestItem::query()->firstOrCreate(
                ['procurement_request_id' => $request->id, 'item_name' => $item['item_name']],
                $item
            );
        }
    }
}
