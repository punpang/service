<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class CategoryRelationship extends Model
{
    protected $table = "category_relationships";

    protected $connection = "order";
    protected $hidden = ["created_at", "updated_at"];

    public function categoryDetail()
    {
        return $this->belongsTo(CategoryDetail::class, "relationship_2", "id")
            ->whereStatusUse(1);
    }

    public static function getRelationship1($relationship_1)
    {
        $CategoryRelationships = self::where("relationship_1", $relationship_1)
            ->whereStatusUse(1)
            ->get();

        foreach ($CategoryRelationships as $Category) {
            $data[] = $Category->categoryDetail;
        }

        return $data;
    }

    public static function getRelationship2($relationship_2)
    {
        $CategoryRelationships = self::where("relationship_2", $relationship_2)
            ->whereStatusUse(1)
            ->get();

        foreach ($CategoryRelationships as $Category) {
            $data[] = $Category->categoryDetail;
        }

        return $data;
    }
}
