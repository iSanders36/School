<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

//eerst maak ik in de route web file een nieuwe user aan zoals hieronder.
    // Route::get('create' , function(){
    //       App\User::create(array(
    //         'name' => 'Sander Schreurs',
    //         'email' => 'Sanderschreurs@test.nl',
    //         'password' => Hash::make('password')));
    // });

//daarna een pagina waar ik mijn user op kan zien en de gegevens van de user omdat ik dan kan controleren of de accessors en mutators werken en de data veranderd
    // Route::get('user', function(){
    //   $user = App\User::find(1);
    //   echo $user->name . '<br />';
    //   echo $user->email;
    // });

    //=============================================================================
    // Accessors
    //=============================================================================

//zoekt een naam attribute in de database en veranderd de data naar eerste letter hoofdletter van alles wat er binnen is.
//$value variable is de data wat er in de table staat.
public function getNameAttribute($value){
    return ucwords($value);
}
//zoekt naar email attribute en maakt er allemaal kleine letters van.
//$value variable is de data wat er in de table staat.
public function getEmailAttribute($value){
    return strtolower($value);
}

    //=============================================================================
    // Mutators
    //=============================================================================

//als er een user wordt geregisteerd schrijft hij de naam van de user altijd met hoofdletter eerste letter naar de database
public function setNameAttribute($value){
      $this->attributes['name'] = ucwords($value);
}

//als er een user wordt geregisteerd schrijft hij de email van de user altijd in strotolower dus kleine letters naar de database
public function setEmailAttribute($value){
      $this->attributes['email'] = strtolower($value);
}

    //=============================================================================
    // beschermde en verborgen velden
    //=============================================================================


//de velden die zijn protected om te bewerken als er geen rechten zijn
protected $fillable = [
    'name', 'email', 'password',
];

//velden die zijn verborgen voor iedereen en niet kunnen aangepast worden
protected $hidden = [
    'password', 'remember_token',
];

protected $casts = [
    'email_verified_at' => 'datetime',
];

}
