<?php

namespace App\Imports;

use App\Models\Consumer;
use App\Models\Order;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Maatwebsite\Excel\Concerns\ToCollection;

class OrderImport implements WithStartRow , ToCollection
{
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
        info($row);
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
            "note"          => $row[9],
            "delivery_note" => "",
            "sell_shipping_cost" => ""
        ]);
        $produit = Product::find($row[5]);
        $product_json = collect();

        $product_json->push([
            "id"          => $produit->id,
            "active"      => 0,
            "product"     => $produit->name,
            "product_name" => $produit->name,
            "unit_cost"   => $row[6],
            "quantity"    => $row[7],
            "sub_total"   => $row[8]
        ]);

        $order = Order::create([
            'status' => $row[10],
            'consumer_id' => $user->id,
            'product_id' => $row[5],
            'note_json' =>  $note_json,
            'quantity' => $row[7],
            'upsell_json'   => $product_json,
            'total'  => $row[8],
            'subTotal' => $row[8],
            'city_id' => $row[4]
        ]);
    }
    }
}
}
