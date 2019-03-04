<?
namespace App\Model\Validation;

use Cake\Validation\Validator;

class CustomValidator extends Validator
{
    public function __construct()
    {
        parent::__construct();
        // Add validation rules here.
    }

    public function titleCheck($value, $prefix){
        $regex = '/'.$prefix.'[0-9]{2}/';
        return (preg_match($regex, $value))?;
    }
}
