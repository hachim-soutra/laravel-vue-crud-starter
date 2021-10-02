<?php

namespace App\Imports;

use App\Models\Consumer;
use App\Models\Historique;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class OrderImport implements WithStartRow, ToCollection, WithCustomCsvSettings

{
    protected $id;
    protected $contact_id;
    private $imported = 0;

    function __construct($id, $contact_id)
    {
        $this->id = $id;
        $this->contact_id = $contact_id;
    }
    public function startRow(): int
    {
        return 2;
    }
    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1',
            'delimiter' => ";"
        ];
    }
    public function getDATA(): array
    {
        return array(
            'imported'     => $this->imported
        );
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (isset($row[1]) && isset($row[2])) {


                $produit = Product::whereName($row[5])->first();
                if ($produit) {
                    $order = Order::create([
                        'order_status_id'       => 1,
                        'consumer_name'         => $row[1],
                        'consumer_phone'        => $row[2],
                        'shipping_adresse'      => $row[3],
                        'consumer_ville'        => $row[4],
                        'product_id'            => $produit->id,
                        'contact_id'            => $this->contact_id,
                        "note"                  => isset($row[8]) ? $row[8] : '',
                        "delivery_note"         => "",
                        'quantity'              => $row[7],
                        'total'                 => $row[7] * $row[6],
                        'subTotal'              => $row[7] * $row[6],
                        'city_id'               => $this->id,
                        'user_id'               => auth()->user()->id,
                    ]);
                    $order->created_at = now();
                    // $order->created_at = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0])->format('Y-m-d');
                    $order->save(['timestamps' => false]);
                    Historique::create([
                        'order_id' => $order->id,
                        'text' => auth()->guard('contact')->check() ? 'partenaire ' . auth()->user()->id . ' import order' : 'Agent ' . auth()->user()->id . ' import order'
                    ]);
                    $this->imported++;
                }
            }
        }
    }
}
