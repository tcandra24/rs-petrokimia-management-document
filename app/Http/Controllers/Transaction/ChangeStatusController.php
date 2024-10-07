<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Disposition;

// Traits
use App\Traits\Disposition\TransactionNumberTrait;

class ChangeStatusController extends Controller
{
    use TransactionNumberTrait;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'note' => 'required',
            'status' => 'required',
        ]);

        try {
            $disposition = Disposition::where('id', $id)->first();

            $data = [
                'status' => $request->status,
                'note' => $request->note
            ];
            if($request->memo_id){
                $numberTransaction = $this->generateNumber($disposition->counter);
                $data['number_transaction'] = $numberTransaction;
            }

            $disposition->update($data);

            toastr()->success('Disposisi Berhasil Diubah Statusnya');
            return redirect()->route('dispositions.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
