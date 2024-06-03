<?php
use Illuminate\Support\Facades\Config;
function uploadImage($folder, $image)
{

    $extention = strtolower($image->guessClientExtension());
    $filename = time().rand(100, 999).'.'.$extention;
    $image->getClientOrignalName = $filename;
    $image->move($folder, $filename);
    return $filename;

}
function get_id_row($model,$a,$b,$c,$d){

$account=$model::where([$a=>$b,$c=>$d])->first();
return $account;
}