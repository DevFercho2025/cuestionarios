<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ConfigPack;
use App\Models\UserPaymentHistory;
use App\Models\ContadorEvaluacion;
use App\Models\transaction;

class testPacksController extends Controller
{
     public function storePackData(Request $request)
    {
        
        $transactionIsValid = true; //por ahora

        if (!$transactionIsValid) {
            return response()->json(['error' => 'Transacción no válida.'], 400);
        }

        //Si algo falla, deshacer.
        DB::beginTransaction();

        try {
            $userId = $request->user_id;
            $packId = 1; //ID fijo para pruebas
            $includedTests = [1, 2, 3]; //IDs de tests incluidos (puedes cambiar esto)

            $transaction = Transaction::create([
                'user_id' => $userId,
                'pack_id' => $packId,
                'amount' => 100,
                'status' => 'success',
                'payer_email' => 'usuario@example.com',
                'payer_name' => 'Usuario de Prueba',
                'payment_type' => 'manual',
                'stripe_payment_method_id' => null,
                'stripe_payment_intent_id' => null,
            ]);

            $configPack = ConfigPack::create([
                'user_id' => $userId,
                'pack_id' => $packId,
                'included_tests_ids' => $includedTests,
                'expiration_date' => now(),
            ]);

            UserPaymentHistory::create([
                'user_id' => $userId,
                'transaction_id' => $transaction->id,
                'used_tests_summary' => json_encode([]),
            ]);

            $contador = ContadorEvaluacion::firstOrNew([
                'user_id' => $userId,
                'pack_id' => $packId,
            ]);

            $contador->available_tests = count($includedTests);
            $contador->used_tests = 0;
            $contador->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paquete adquirido correctamente',
                'transaction_id' => $transaction->id,
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar paquete: ' . $e->getMessage()
            ], 500);
        }
    }
}
