<?php

namespace App\Imports;

use App\Models\Consumer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Maatwebsite\Excel\Concerns\ToCollection;

class OrderImport implements WithStartRow , ToCollection
{
    protected $id;
    protected $contact_id;

    function __construct($id, $contact_id) {
        $this->id = $id;
        $this->contact_id = $contact_id;
    }
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if(isset($row[1]) && isset($row[1])){

        $name   = explode(" ",$row[1],2);
        $prenom = $name[0];
        $nom    = $name[1];

        $user = Consumer::firstOrNew([
            'prenom' =>  $prenom,
            'nom'    =>  $nom
        ]);
        $user->adresse = $row[3];
        $user->ville   = $row[4];
        $user->phone   = $row[2];
        $user->status  = "active";
        $user->save();

        $note_json = collect([
            "note"               => $row[8],
            "delivery_note"      => "",
            "sell_shipping_cost" => ""
        ]);
        $produit = Product::whereName($row[5])->first();
        $product_json = collect();

        $product_json->push([
            "id"            => $produit->id,
            "active"        => 0,
            "product"       => $produit->name,
            "product_name"  => $produit->name,
            "unit_cost"     => $row[6],
            "quantity"      => $row[7],
            "sub_total"     => $row[7] * $row[6]
        ]);

        $order = Order::create([
            'order_status_id'       => 1,
            'consumer_id'           => $user->id,
            'contact_id'            => $this->contact_id,
            'product_id'            => $produit->id,
            'note_json'             => $note_json,
            'quantity'              => $row[7],
            'upsell_json'           => $product_json,
            'total'                 =>  $row[7] * $row[6],
            'subTotal'              =>  $row[7] * $row[6],
            'shipping_adresse'      => $row[3].", ". $row[4],
            'city_id'               => $this->id,

        ]);
        $order->created_at = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0])->format('Y-m-d');
        $order->save(['timestamps' => false]);
    }
    }
}
}
