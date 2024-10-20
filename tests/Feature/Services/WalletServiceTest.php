<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Student;
use App\Models\StudentBill;
use App\Services\WalletService;
use Database\Seeders\UserSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\ProductSeeder;
use Database\Seeders\StudentSeeder;
use App\Models\FinancialTransaction;

beforeEach(function () {
    DB::delete("delete from student_bill");
    DB::delete("delete from products");
    DB::delete("delete from students");
    DB::delete("delete from users");
    DB::delete("delete from financial_transactions");
    DB::delete("delete from wallets");
    $this->WalletService = app()->make(WalletService::class);
});

test('transfer from SYSTEM to YAYASAN success with data', function () {
    $this->seed([UserSeeder::class, StudentSeeder::class, ProductSeeder::class, WalletSeeder::class]);

    $user = User::where('email', 'admin@gmail.com')->first();
    $this->actingAs($user);

    $studentModel = Student::first();
    $productModel = Product::first();
    $studentBillModel = StudentBill::create([
        'student_id' => $studentModel->id,
        'product_id' => $productModel->id,
        'product_name' => $productModel->name,
        'product_price' => $productModel->price,
        'validated_at' => now(),
        'validated_by' => auth('web')->user()->id,
    ]);

    $description = auth('web')->user()->name . ' - ' . auth('web')->user()->phone . ' melakukan validasi biaya administrasi ' . $studentModel->name . ' #' . $studentModel->id . ' - ' . $studentModel->user->phone;

    $result = $this->WalletService->transfer('SYSTEM', 'YAYASAN', $studentBillModel->product_price, [
        'student_bill_id' => $studentBillModel->id,
        'name' => $studentBillModel->product_name,
        'type' => 'credit,validation,system',
        'description' => $description,
    ]);
    $this->assertTrue($result);

    $financialTransaction = FinancialTransaction::first();
    $this->assertNotNull($financialTransaction);
    $this->assertEquals($studentBillModel->id, $financialTransaction->student_bill_id);
    $this->assertEquals($studentBillModel->product_name, $financialTransaction->name);
    $this->assertEquals('credit,validation,system', $financialTransaction->type);
    $this->assertEquals($studentBillModel->product_price, $financialTransaction->amount);
    $this->assertEquals($description, $financialTransaction->description);
    $this->assertEquals('SYSTEM', $financialTransaction->from_wallet_id);
    $this->assertEquals('YAYASAN', $financialTransaction->to_wallet_id);
});

test('transfer from SYSTEM to YAYASAN success without data', function () {
    $this->seed([WalletSeeder::class]);
    $result = $this->WalletService->transfer('SYSTEM', 'YAYASAN', 100000);
    $this->assertTrue($result);

    $financialTransaction = FinancialTransaction::first();
    $this->assertNotNull($financialTransaction);
    $this->assertEquals('Transfer Saldo', $financialTransaction->name);
    $this->assertEquals('transfer', $financialTransaction->type);
    $this->assertEquals(100000, $financialTransaction->amount);
    $this->assertEquals('Transfer saldo 100000 dari SYSTEM ke YAYASAN', $financialTransaction->description);
    $this->assertEquals('SYSTEM', $financialTransaction->from_wallet_id);
    $this->assertEquals('YAYASAN', $financialTransaction->to_wallet_id);
});

test('transfer from YAYASAN to SYSTEM success without data', function () {
    $this->seed([WalletSeeder::class]);
    $this->WalletService->transfer('SYSTEM', 'YAYASAN', 100000);
    $result = $this->WalletService->transfer('YAYASAN', 'SYSTEM', 100000);
    $this->assertTrue($result);

    $financialTransaction = FinancialTransaction::where('from_wallet_id', 'YAYASAN')->first();
    $this->assertNotNull($financialTransaction);
    $this->assertEquals('Transfer Saldo', $financialTransaction->name);
    $this->assertEquals('transfer', $financialTransaction->type);
    $this->assertEquals(100000, $financialTransaction->amount);
    $this->assertEquals('Transfer saldo 100000 dari YAYASAN ke SYSTEM', $financialTransaction->description);
    $this->assertEquals('YAYASAN', $financialTransaction->from_wallet_id);
    $this->assertEquals('SYSTEM', $financialTransaction->to_wallet_id);
});
