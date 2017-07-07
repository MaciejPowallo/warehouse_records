<?php

namespace App;
use App\User;
use App\Pz_document;
use App\Wz_document;
use App\Zw_document;
use App\Lt_document;
use App\Booking;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
	protected $fillable = [
        'user_id', 'id_type', 'id_grade', 'catalog_nr', 'index', 'product_name', 'unit', 'price', 'description', 'quantity', 'total_quantity', 'disable',
    ];

    /*----------------------------------------
     *   Produkt jest utworzona przez jednego użytkownika
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*----------------------------------------
     *   Produkt jest danego typu
     */
    public function type()
    {
        return $this->belongsTo('App\Type', 'type_id');
    }

    /*----------------------------------------
     *   Produkt jest danego gatunku
     */
    public function grade()
    {
        return $this->belongsTo('App\Grade', 'grade_id');
    } 

    /*----------------------------------------
     *   Produkt występuje w wielu dokumantach przyjęcia PZ
     */
    public function pz_documents()
    {
        return $this->belongsToMany('App\Pz_document', 'product_pz_documents', 'product_id', 'pz_id')->withTimestamps();
    } 

    /*----------------------------------------
     *   Produkt występuje w wielu dokumantach wydania WZ
     */
    public function wz_documents()
    {
        return $this->belongsToMany('App\Wz_document', 'product_wz_documents', 'product_id', 'wz_id')->withTimestamps();
    } 

   /*----------------------------------------
     *   Produkt występuje w wielu dokumantach zwtotach ZW
     */
    public function zw_documents()
    {
        return $this->belongsToMany('App\Zw_document', 'product_zw_documents', 'product_id', 'zw_id')->withTimestamps();
    } 

   /*----------------------------------------
     *   Produkt występuje w wielu dokumantach likwidacji LT
     */
    public function lt_documents()
    {
        return $this->belongsToMany('App\Lt_document', 'product_lt_documents', 'product_id', 'lt_id')->withTimestamps();
    } 

   /*----------------------------------------
     *   Produkt występuje w wielu rezerwacjach
     */
    public function bookings()
    {
        return $this->belongsToMany('App\Booking', 'product_bookings', 'product_id', 'booking_id')->withTimestamps();
    } 

   /*----------------------------------------
     *   Produkt występuje w wielu transportach
     */
    public function transports()
    {
        return $this->belongsToMany('App\Return_transport', 'product_return_transports', 'product_id', 'transport_id')->withTimestamps();
    } 
}
