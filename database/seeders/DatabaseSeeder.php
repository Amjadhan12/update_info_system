<?php

namespace Database\Seeders;

use App\Models\CashAccount;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //user seeder
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@gmail.com";
        $user->password = Hash::make("admin123");
        $user->save();

        //currency seeder
        $currency = new Currency();
        $currency->name = "AFN";
        $currency->rate = "1";
        $currency->save();

        //Unit seeder
        Unit::insert([
            ['name' => 'Piece']
        ]);
        //Cash Account seeder
        CashAccount::insert([
            ['user_id' => '1', 'name' => 'Cash Dakhal'],
        ]);
        //Stock seeder
        Stock::insert([
            ['user_id' => '1', 'name' => 'Shop'],
            ['user_id' => '1', 'name' => 'Stock'],
        ]);

        //settting seeder
        $setting = new Setting();
        $setting->user_id = "1";
        $setting->title_pa = "پرزه فروشی حاجی خان علی عرب";
        $setting->title_en = "Haji Khan Ali Arab Car Parts Wholesale";
        $setting->phone1 = "0764497115";
        $setting->phone2 = "0787831352";
        // $setting->email = "khanaliarab@gmail.com";
        $setting->address = "راسته سابقه ګمرک، مهمند مارکیټ، دوکان نمبر ۷، ۸، ۹،۱۰ ، جلال اباد، افغانستان";
        $setting->bill_text = "No Return";
        $setting->save();
    }
}
